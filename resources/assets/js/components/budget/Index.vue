<template>
    <div class="main">

        <app-window :title="$t('title.budget')"></app-window>

        <div class="toolbar toolbar-primary">
            <app-sidebar-toggle></app-sidebar-toggle>

            <div style="line-height: 58px;" class="col-flex">
                <a href="#" class="text-light" :title="$t('action.previousMonth')"
                   @click.prevent.stop="showPreviousMonth">
                    <span class="fa fa-chevron-left"></span>
                </a>
                <date-format
                        class="h4 mb-sm-0"
                        :value="month"
                        :options="{year: 'numeric', month: 'short'}">
                </date-format>
                <a href="#" class="text-light" :title="$t('action.nextMonth')" @click.prevent.stop="showNextMonth">
                    <span class="fa fa-chevron-right"></span>
                </a>
            </div>

            <transition name="fade">
                <div v-if="!loading" class="text-right">
                    <div class="badge px-3"
                         :class="[{ 'badge-danger': unallocated < 0 }, { 'badge-success': unallocated >= 0 }]">
                        <money-format
                                class="h3"
                                :value="unallocated">
                        </money-format>
                        <br>
                        <span class="small">{{ $t('form.unallocated') }}</span>
                    </div>
                </div>
            </transition>
            <transition name="fade">
                <div v-if="!loading" class="d-none d-lg-block small">
                    {{ $t('form.previousMonth') }}:
                    <money-format
                            class="font-weight-bold"
                            :value="sheet.previousMonth">
                    </money-format>
                    <br>
                    {{ $t('form.income') }}:
                    <money-format
                            class="font-weight-bold"
                            :value="sheet.income">
                    </money-format>
                    <br>
                    {{ $t('form.allocated') }}:
                    <money-format
                            class="font-weight-bold"
                            :value="sheet.allocated">
                    </money-format>
                </div>
            </transition>
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
                <div class="budget-column-drag"></div>
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
                <div class="budget-column-actions"></div>
            </div>

            <draggable v-model="rows" :options="{handle:'.handle'}" @end="persistSorting">
                <category-row
                        v-for="(row, index) in rows"
                        :key="month+'#'+row.id"
                        :month="month"
                        :value="row"
                        @update:value="val => rows.splice(index, 1, val)">
                    <div slot="actions">
                        <a href="#" @click.prevent="showEditCategoryModal(row)" class="text-muted">
                            <span class="fa fa-pencil"></span>
                        </a>
                    </div>
                </category-row>
            </draggable>

            <app-spinner v-if="loading"></app-spinner>
        </div>

        <b-modal ref="newCategoryModal" @shown="focusNewCategoryInput" :title="$t('action.new.category')">
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
                           ref="newCategoryInput"
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

        <b-modal ref="editCategoryModal" @shown="focusEditCategoryInput" :title="$t('action.edit.category')">
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
                           ref="editCategoryInput"
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
    import row from './Row.vue'

    export default {
        components: {
            draggable,
            'category-row': row
        },
        computed: {
            allocated: function () {
                let sum = 0;
                this.rows.forEach(function (row) {
                    sum += row.budget;
                });
                return sum;
            },
            unallocated: function () {
                return this.sheet.previousMonth + this.sheet.income - this.allocated;
            }
        },
        data: () => ({
            sheet: {
                income: 0,
                allocated: 0,
                previousMonth: 0
            },
            loading: true,
            month: new Date().getFullYear() + '-' + (new Date().getMonth() + 1),
            rows: [],
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

        mounted() {
            this.loadSheet('/api/month');
        },

        methods: {
            loadSheet(url) {
                this.loading = true;
                this.rows = [];

                axios
                    .get(url)
                    .then(response => {
                        // JSON responses are automatically parsed.
                        this.loading = false;
                        this.sheet = response.data.data;
                        this.month = this.sheet.month;
                        this.rows = this.sheet.rows;
                        this.previousMonth = response.data.links.prev;
                        this.nextMonth = response.data.links.next;
                    })
                    .catch(e => {
                        this.errors.push(e)
                    })
            },
            showPreviousMonth() {
                let currentDate = new Date(this.month);
                let newDate = new Date(currentDate.setMonth(currentDate.getMonth() - 1));
                this.month = newDate.getFullYear() + '-' + (newDate.getMonth() + 1);

                this.loadSheet(this.previousMonth);
            },

            showNextMonth() {
                let currentDate = new Date(this.month);
                let newDate = new Date(currentDate.setMonth(currentDate.getMonth() + 1));
                this.month = newDate.getFullYear() + '-' + (newDate.getMonth() + 1);

                this.loadSheet(this.nextMonth);
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
            focusNewCategoryInput() {
                this.$refs.newCategoryInput.focus();
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
                                this.$store.commit('ADD_CATEGORY', response.data.data);
                                this.addRow(response.data.data);
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
            focusEditCategoryInput() {
                this.$refs.editCategoryInput.focus();
            },
            updateCategory() {
                this.$validator.validateAll('editCategory').then(isValid => {
                    this.editCategory.validated = true;

                    if (isValid) {
                        axios
                            .put('/api/categories/' + this.editCategory.id, {
                                'name': this.editCategory.name
                            })
                            .then(response => {
                                this.rows.find(x => x.id === this.editCategory.id).name = response.data.data.name;
                                this.$store.commit('ADD_CATEGORY', response.data.data);
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
                category.month = this.month;
                category.budget = 0;
                category.available = 0;
                category.previousMonth = 0;
                category.activity = 0;
                category.recommendedBudget = 0;

                this.rows.push(category);
            },
            removeRow(id) {
                this.rows = this.rows.filter(item => item.id !== id);
            },
            persistSorting() {
                let list = this.rows.reduce(function (prevVal, elem) {
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