<template>
    <div v-if="sheet !== null">

        <div class="toolbar toolbar-primary">
            <div class="form-row">
                <div class="col-xs-12 col-sm-8 col-lg-6 h2 mb-sm-0 text-center text-sm-left">
                    <button class="btn btn-outline-secondary"
                            :title="$t('action.previousMonth')" @click="showPreviousMonth">
                        <span class="fa fa-chevron-left"></span>
                    </button>
                    <span v-html="$formatDate(new Date(sheet.month), { year: 'numeric', month: 'short' })"></span>
                    <button class="btn btn-outline-secondary"
                            :title="$t('action.nextMonth')" @click="showNextMonth">
                        <span class="fa fa-chevron-right"></span>
                    </button>
                </div>
                <div class="col-sm-4 col-lg-3 text-center text-sm-right">
                    <div class="badge" :class="[{ 'badge-danger': sheet.available < 0 }, 'badge-success']">
                        <strong class="h3"
                                v-html="$formatNumber(toBeBudgeted, {style: 'currency', currency: currency})"></strong><br>
                        <span class="small">{{ $t('form.toBeBudgeted') }}</span>
                    </div>
                </div>
                <div class="col d-none d-lg-block col-lg-3 small">
                    {{ $t('form.previousMonth') }}:
                    <strong v-html="$formatNumber(sheet.previousMonth, {style: 'currency', currency: currency})"></strong>
                    <br>
                    {{ $t('form.funds') }}:
                    <strong v-html="$formatNumber(sheet.funds, {style: 'currency', currency: currency})"></strong>
                    <br>
                    {{ $t('form.budgeted') }}:
                    <strong v-html="$formatNumber(budgeted, {style: 'currency', currency: currency})"></strong>
                </div>
            </div>
        </div>


        <div class="toolbar toolbar-secondary">
            <div class="row">
                <div class="col">
                    <button class="btn btn-link" v-on:click="showNewCategoryModal">
                        <span class="fa fa-plus"></span> {{ $t('action.new.category') }}
                    </button>
                </div>
            </div>
        </div>

        <table class="table table-sm content">
            <thead>
            <tr>
                <th width="12"></th>
                <th>
                    {{ $t('form.category') }}
                </th>
                <th class="text-right" width="130">{{ $t('form.budgeted') }}</th>
                <th class="text-right d-none d-lg-table-cell ">{{ $t('form.activity') }}</th>
                <th class="text-right">{{ $t('form.available') }}</th>
            </tr>
            </thead>
            <draggable v-model="sheet.rows" :options="{handle:'.handle'}" element="tbody" @end="persistSorting">
                <tr v-for="row in sheet.rows" :key="row.id">
                    <td>
                        <span class="handle d-none d-sm-inline-block"></span>
                    </td>
                    <td>
                        <a class="link-action text-dark"
                           :title="$t('action.edit.category')"
                           v-on:click="showEditCategoryModal(row)">
                            {{ row.name }}
                        </a>
                    </td>
                    <category-budget
                            :value="row.budgeted"
                            v-on:update:value="val => updateBudget(row, val)">
                    </category-budget>
                    <td class="d-none d-lg-table-cell text-right"
                        :class="[{ 'text-muted': row.activity == 0 }, 'text-dark']"
                        v-html="$formatNumber(row.activity, {style: 'currency', currency: currency})">
                    </td>
                    <td class="text-right">
                        <span style="font-size: 100%" class="badge"
                              :class="[{ 'badge-danger': available(row) < 0 }, { 'badge-success': available(row) > 0 }, 'badge-secondary']"
                              v-html="$formatNumber(available(row), {style: 'currency', currency: currency})">
                        </span>
                    </td>
                </tr>
            </draggable>
        </table>

        <b-modal ref="newCategoryModal" :title="$t('action.new.category')">
            <form @submit.stop.prevent="createCategory">
                <b-form-input type="text" :placeholder="$t('form.name')" v-model="newCategory.name"></b-form-input>
            </form>

            <div slot="modal-footer">
                <button class="btn btn-light" v-on:click="hideNewCategoryModal">
                    {{ $t('action.cancel') }}
                </button>
                <button class="btn btn-primary" v-on:click="createCategory">
                    {{ $t('action.save') }}
                </button>
            </div>
        </b-modal>

        <b-modal ref="editCategoryModal" :title="$t('action.edit.category')">
            <form @submit.stop.prevent="editCategory">
                <b-form-input type="text" :placeholder="$t('form.name')" v-model="editCategory.name"></b-form-input>
            </form>
            <div slot="modal-footer" class="text-right" style="width: 100%;">
                <div class="float-left">
                    <button class="btn btn-outline-danger"
                            :title="$t('action.delete.category')"
                            v-on:click="deleteCategory">
                        <span class="fa fa-trash"></span>
                    </button>
                </div>

                <button class="btn btn-light" v-on:click="hideEditCategoryModal">
                    {{ $t('action.cancel') }}
                </button>
                <button class="btn btn-primary" v-on:click="updateCategory">
                    {{ $t('action.save') }}
                </button>
            </div>
        </b-modal>
    </div>
</template>

<script>
    import draggable from 'vuedraggable'

    export default {
        props: ['budget'],
        components: {
            draggable,
            'category-budget': require('./CategoryBudget.vue')
        },
        computed: {
            budgeted: function () {
                let sum = 0;
                this.sheet.rows.forEach(function (row) {
                    sum += row.budgeted;
                });
                return sum;
            },
            currency: function () {
                return window.currency;
            },
            toBeBudgeted: function () {
                return this.sheet.previousMonth + this.sheet.funds - this.budgeted;
            }
        },
        data: () => ({
            sheet: null,
            previousMonth: null,
            nextMonth: null,
            newCategory: {
                'name': ''
            },
            editCategory: {
                'id': '',
                'name': ''
            }
        }),

        created() {
            this.loadSheet('/api/budgets/' + this.budget + '/month');
        },

        methods: {
            loadSheet(url) {
                axios
                    .get(url)
                    .then(response => {
                        // JSON responses are automatically parsed.
                        this.sheet = response.data.data;
                        this.previousMonth = response.data.links.prev;
                        this.nextMonth = response.data.links.next;
                    })
                    .catch(e => {
                        this.errors.push(e)
                    })
            },
            showPreviousMonth() {
                this.loadSheet(this.previousMonth);
            },

            showNextMonth() {
                this.loadSheet(this.nextMonth);
            },


            available: function (category) {
                return category.previousMonth + category.budgeted + category.activity;
            },
            updateBudget: function (category, value) {
                category.budgeted = value;

                axios
                    .put('/api/categories/' + category.id + '/budget', {
                        'month': this.sheet.month,
                        'amount': value
                    })
                    .then(response => {
                        category = response.data;
                    })
                    .catch(e => {
                        console.error(e);
                    });

            },

            showNewCategoryModal() {
                this.newCategory.name = '';
                this.$refs.newCategoryModal.show();
            },
            hideNewCategoryModal() {
                this.$refs.newCategoryModal.hide();
            },
            createCategory() {
                axios
                    .post('/api/categories', {
                        'name': this.newCategory.name,
                        'budget': this.budget
                    })
                    .then(response => {
                        this.addRow(response.data);
                    })
                    .catch(e => {
                        console.error(e);
                    });

                this.hideNewCategoryModal();
            },

            showEditCategoryModal(row) {
                this.editCategory.id = row.id;
                this.editCategory.name = row.name;
                this.$refs.editCategoryModal.show();
            },
            hideEditCategoryModal() {
                this.$refs.editCategoryModal.hide();
            },
            updateCategory() {
                this.sheet.rows.find(x => x.id === this.editCategory.id).name = this.editCategory.name;

                axios
                    .put('/api/categories/' + this.editCategory.id, {
                        'name': this.editCategory.name
                    })
                    .catch(e => {
                        console.error(e);
                    });

                this.hideEditCategoryModal();
            },
            deleteCategory() {
                this.removeRow(this.editCategory.id);

                axios
                    .delete('/api/categories/' + this.editCategory.id)
                    .catch(e => {
                        console.error(e);
                    });

                this.hideEditCategoryModal();
            },

            addRow(category) {
                category.month = this.sheet.month;
                category.budgeted = 0;
                category.available = 0;
                category.previousMonth = 0;
                category.activity = 0;

                this.sheet.rows.push(category);
            },
            removeRow(id) {
                this.sheet.rows = this.sheet.rows.filter(item => item.id !== id);
            },
            persistSorting: function (category, value) {
                let list = this.sheet.rows.reduce(function (prevVal, elem) {
                    prevVal.push(elem.id);
                    return prevVal;
                }, []);

                axios
                    .put('/api/budgets/' + this.budget + '/sort', {
                        'categories': list
                    })
                    .catch(e => {
                        console.error(e);
                    });

            }

        }
    }
</script>