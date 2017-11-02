<template>
    <div v-if="sheet !== null" class="main">

        <app-window :title="$t('title.budget')"></app-window>

        <div class="toolbar toolbar-primary">
            <app-sidebar-toggle></app-sidebar-toggle>

            <div class="col-flex">
                <a href="#" class="text-light" :title="$t('action.previousMonth')"
                   @click.prevent.stop="showPreviousMonth">
                    <span class="fa fa-chevron-left"></span>
                </a>
                <date-format
                        class="h4 mb-sm-0"
                        :value="sheet.month"
                        :options="{year: 'numeric', month: 'short'}">
                </date-format>
                <a href="#" class="text-light" :title="$t('action.nextMonth')" @click.prevent.stop="showNextMonth">
                    <span class="fa fa-chevron-right"></span>
                </a>
            </div>

            <div class="text-right">
                <div class="badge px-3"
                     :class="[{ 'badge-danger': toBeBudgeted < 0 }, { 'badge-success': toBeBudgeted >= 0 }]">
                    <money-format
                            class="h3"
                            :value="toBeBudgeted">
                    </money-format>
                    <br>
                    <span class="small">{{ $t('form.unallocated') }}</span>
                </div>
            </div>
            <div class="d-none d-lg-block small">
                {{ $t('form.previousMonth') }}:
                <money-format
                        class="font-weight-bold"
                        :value="sheet.previousMonth">
                </money-format>
                <br>
                {{ $t('form.funds') }}:
                <money-format
                        class="font-weight-bold"
                        :value="sheet.funds">
                </money-format>
                <br>
                {{ $t('form.budget') }}:
                <money-format
                        class="font-weight-bold"
                        :value="sheet.budgeted">
                </money-format>
            </div>
        </div>

        <div class="toolbar toolbar-secondary">
            <div class="row">
                <div class="col">
                    <button class="btn" v-on:click="showNewCategoryModal">
                        <span class="fa fa-plus"></span> {{ $t('action.new.category') }}
                    </button>
                </div>
            </div>
        </div>

        <div class="content budget">
            <div class="budget-header">
                <div class="budget-column-drag">
                    &nbsp;
                </div>
                <div class="budget-column-name">
                    {{ $t('form.category') }}
                </div>
                <div class="budget-column-budget">
                    {{ $t('form.budget') }}
                </div>
                <div class="budget-column-activity d-none d-lg-block">
                    {{ $t('form.activity') }}
                </div>
                <div class="budget-column-available">
                    {{ $t('form.available') }}
                </div>
            </div>

            <draggable v-model="sheet.rows" :options="{handle:'.handle'}" @end="persistSorting">
                <div class="budget-row" v-for="row in sheet.rows" :key="row.id">
                    <div class="budget-column-drag">
                        <span class="handle"></span>
                    </div>
                    <div class="budget-column-name">
                        <a class="link-action text-dark"
                           v-bind:title="$t('action.edit.category')"
                           v-on:click="showEditCategoryModal(row)">
                            {{ row.name }}
                        </a>
                    </div>
                    <div class="budget-column-budget">
                        <money-input
                                class="text-right py-0 px-1 border-0"
                                ref="input"
                                v-bind:class="[{ 'text-muted': row.budgeted == 0 }, { 'text-dark': row.budgeted != 0 }]"
                                v-bind:value="row.budgeted"
                                v-on:update:value="val => updateBudget(row, val)">
                        </money-input>
                    </div>
                    <div class="budget-column-activity d-none d-lg-block">
                        <money-format
                                v-bind:class="[{ 'text-muted': row.activity == 0 }, { 'text-dark': row.activity != 0 }]"
                                v-bind:value="row.activity">
                        </money-format>
                    </div>
                    <div class="budget-column-available">
                        <money-format
                                style="font-size: 100%"
                                class="badge"
                                v-bind:class="[{ 'badge-danger': available(row) < 0 }, { 'badge-success': available(row) > 0 }, { 'badge-light': available(row) == 0 }]"
                                v-bind:value="available(row)"
                                v-b-tooltip.left
                                v-bind:title="$t('form.recommendedBudget')+': '+$formatMoney(row.recommendedBudget)">
                        </money-format>
                    </div>
                </div>
            </draggable>
        </div>

        <b-modal ref="newCategoryModal" :title="$t('action.new.category')">
            <form v-on:submit.stop.prevent="createCategory"
                  v-bind:class="[{'was-validated': newCategory.validated}]"
                  data-vv-scope="newCategory"
                  novalidate>
                <div class="form-group">
                    <label for="name" class="sr-only">{{$t('form.name')}}</label>
                    <input id="name" type="text" class="form-control"
                           :placeholder="$t('form.name')"
                           v-model="newCategory.name"
                           v-validate="'required'"
                           data-vv-name="name"
                           :data-vv-as="$t('form.name')">
                    <span class="invalid-feedback">{{ errors.first('newCategory.name') }}</span>
                </div>
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
            <form v-on:submit.stop.prevent="updateCategory"
                  v-bind:class="[{'was-validated': editCategory.validated}]"
                  data-vv-scope="editCategory"
                  novalidate>
                <div class="form-group">
                    <label for="name" class="sr-only">{{$t('form.name')}}</label>
                    <input id="name" type="text" class="form-control"
                           :placeholder="$t('form.name')"
                           v-model="editCategory.name"
                           v-validate="'required'"
                           data-vv-name="name"
                           :data-vv-as="$t('form.name')">
                    <span class="invalid-feedback">{{ errors.first('editCategory.name') }}</span>
                </div>
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
        components: {
            'draggable': draggable
        },
        computed: {
            budgeted: function () {
                let sum = 0;
                this.sheet.rows.forEach(function (row) {
                    sum += row.budgeted;
                });
                return sum;
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
                name: '',
                validated: false
            },
            editCategory: {
                id: '',
                name: '',
                validated: false
            }
        }),

        created() {
            this.loadSheet('/api/month');
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
                // Reset Validation
                this.newCategory.validated = false;
                this.errors.clear('newCategory');

                // Reset Data
                this.newCategory.name = '';
                this.$refs.newCategoryModal.show();
            },
            hideNewCategoryModal() {
                this.$refs.newCategoryModal.hide();
            },
            createCategory() {

                this.$validator.validateAll('newCategory').then(isValid => {
                    this.newCategory.validated = true;

                    if (isValid) {
                        axios
                            .post('/api/categories', {
                                'name': this.newCategory.name
                            })
                            .then(response => {
                                this.$store.commit('ADD_CATEGORY', response.data);
                                this.addRow(response.data);
                            })
                            .catch(e => {
                                console.error(e);
                            });

                        this.hideNewCategoryModal();
                    }
                });

            },

            showEditCategoryModal(row) {
                // Reset Validation
                this.editCategory.validated = false;
                this.errors.clear('editAccount');

                // Reset Data
                this.editCategory.id = row.id;
                this.editCategory.name = row.name;

                this.$refs.editCategoryModal.show();
            },
            hideEditCategoryModal() {
                this.$refs.editCategoryModal.hide();
            },
            updateCategory() {
                this.$validator.validateAll('editCategory').then(isValid => {
                    this.editCategory.validated = true;

                    if (isValid) {
                        this.sheet.rows.find(x => x.id === this.editCategory.id).name = this.editCategory.name;

                        axios
                            .put('/api/categories/' + this.editCategory.id, {
                                'name': this.editCategory.name
                            })
                            .then(response => {
                                this.$store.commit('ADD_CATEGORY', response.data);
                            })
                            .catch(e => {
                                console.error(e);
                            });

                        this.hideEditCategoryModal();
                    }
                });
            },
            deleteCategory() {
                this.removeRow(this.editCategory.id);

                axios
                    .delete('/api/categories/' + this.editCategory.id)
                    .then(response => {
                        this.$store.commit('REMOVE_CATEGORY', response.data);
                    })
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
                    .put('/api/categories/sort', {
                        'categories': list
                    })
                    .catch(e => {
                        console.error(e);
                    });

            }

        }
    }
</script>