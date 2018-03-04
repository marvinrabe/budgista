<template>
    <div class="main">

        <app-toolbar :title="$t('title.budget')">
            <div slot="title" class="d-flex">
                <a href="#" class="text-light small"
                   :title="$t('action.previousMonth')"
                   @click.prevent.stop="showPreviousMonth">
                    <font-awesome-icon icon="chevron-left"/>
                </a>
                <date-format
                        :value="month"
                        class="mx-1"
                        :options="{year: 'numeric', month: 'short'}">
                </date-format>
                <a href="#" class="text-light small"
                   :title="$t('action.nextMonth')"
                   @click.prevent.stop="showNextMonth">
                    <font-awesome-icon icon="chevron-right"/>
                </a>
            </div>

            <div class="d-none d-sm-block ml-auto">
                <transition name="fade">
                    <div class="d-flex align-items-center" v-if="!loading">
                        <div class="d-none d-lg-block kpi small mr-2">
                            <money-format
                                    class="font-weight-bold"
                                    :value="sheet.previousMonth">
                            </money-format><br>
                            <span class="kpi-label">{{ $t('form.previousMonth') }}</span>
                        </div>
                        <div class="d-none d-lg-block kpi small mr-2">
                            <money-format
                                    class="font-weight-bold"
                                    :value="sheet.income">
                            </money-format><br>
                            <span class="kpi-label">{{ $t('form.income') }}</span>
                        </div>
                        <div class="d-none d-lg-block kpi small mr-2">
                            <money-format
                                    class="font-weight-bold"
                                    :value="sheet.allocated">
                            </money-format><br>
                            <span class="kpi-label">{{ $t('form.allocated') }}</span>
                        </div>

                        <div class="mr-1 badge"
                             :class="[{ 'badge-danger': unallocated < 0 }, { 'badge-success': unallocated >= 0 }]">
                            <money-format
                                    class="h4 p-2 text-number"
                                    :value="unallocated">
                            </money-format>
                            <br>
                            <span class="small">{{ $t('form.unallocated') }}</span>
                        </div>
                    </div>
                </transition>
            </div>

            <div style="flex: 100%; align-items: center;" class="d-flex d-sm-none p-2"
                 :class="[{ 'bg-danger': unallocated < 0 }, { 'bg-success': unallocated >= 0 }]">
                <div class="col-flex text-left small">
                    {{ $t('form.unallocated') }}
                </div>
                <transition name="fade">
                    <div class="col-flex text-right" v-if="!loading">
                        <money-format
                                class="h5 mb-0 text-number"
                                :value="unallocated">
                        </money-format>
                    </div>
                </transition>
            </div>

        </app-toolbar>

        <div class="toolbar toolbar-secondary">
            <button class="btn btn-primary" v-on:click="showNewCategoryModal">
                <font-awesome-icon icon="plus"/>
                {{ $t('action.new.category') }}
            </button>
        </div>

        <div class=" container-fluid">
            <div class="budget-header">
                <div class="budget-column-drag"></div>
                <div class="budget-column-name">
                    {{ $t('form.category') }}
                </div>
                <div class="budget-column-values">
                    <div class="budget-column-budget">
                        {{ $t('form.budget') }}
                    </div>
                    <div class="budget-column-activity">
                        {{ $t('form.activity') }}
                    </div>
                    <div class="budget-column-available">
                        {{ $t('form.available') }}
                    </div>
                </div>
            </div>
        </div>

        <div class="content container-fluid">
            <draggable v-model="rows" :options="{handle:'.handle'}" @end="persistSorting">
                <category-row
                        v-for="(row, index) in rows"
                        :key="month+'#'+row.id"
                        :month="month"
                        :value="row"
                        @update:value="val => rows.splice(index, 1, val)"
                        @edit:category="row => showEditCategoryModal(row)"/>
            </draggable>

            <app-spinner v-if="loading"></app-spinner>
        </div>

        <modal v-if="newCategory.modalVisible" @close="hideNewCategoryModal" :title="$t('action.new.category')">
            <form slot="body"
                  v-on:submit.stop.prevent="createCategory"
                  v-bind:class="[{'was-validated': newCategory.validated}]"
                  data-vv-scope="newCategory"
                  novalidate>
                <div class="form-group">
                    <label for="name" v-html="$t('form.name')"></label>
                    <input id="name" type="text" class="form-control"
                           v-model="newCategory.name"
                           v-validate="'required'"
                           v-focus
                           data-vv-name="name"
                           :data-vv-as="$t('form.name')">
                    <span class="invalid-feedback">{{ errors.first('newCategory.name') }}</span>
                </div>
            </form>

            <div slot="footer">
                <button class="btn btn-text-light" v-on:click="hideNewCategoryModal">
                    {{ $t('action.cancel') }}
                </button>
                <button class="btn btn-primary" v-on:click="createCategory">
                    {{ $t('action.save') }}
                </button>
            </div>
        </modal>

        <modal v-if="editCategory.modalVisible" @close="hideEditCategoryModal" :title="$t('action.edit.category')">
            <form slot="body"
                  v-on:submit.stop.prevent="updateCategory"
                  v-bind:class="[{'was-validated': editCategory.validated}]"
                  data-vv-scope="editCategory"
                  novalidate>
                <div class="form-group">
                    <label for="name" v-html="$t('form.name')"></label>
                    <input id="name" type="text" class="form-control"
                           v-model="editCategory.name"
                           v-validate="'required'"
                           v-focus
                           data-vv-name="name"
                           :data-vv-as="$t('form.name')">
                    <span class="invalid-feedback">{{ errors.first('editCategory.name') }}</span>
                </div>
            </form>
            <div slot="footer">
                <div class="float-left">
                    <button class="btn btn-outline-danger"
                            :title="$t('action.delete.category')"
                            @click="deleteCategory(editCategory.id)">
                        <font-awesome-icon :icon="['far', 'trash-alt']"/>
                    </button>
                </div>

                <button class="btn btn-text-light" v-on:click="hideEditCategoryModal">
                    {{ $t('action.cancel') }}
                </button>
                <button class="btn btn-primary" v-on:click="updateCategory">
                    {{ $t('action.save') }}
                </button>
            </div>
        </modal>

        <delete-category ref="deleteCategory" @delete:category="refresh"></delete-category>
    </div>
</template>

<style>
    .kpi {
        text-align: center;
    }

    .kpi-label {
        opacity: .8;
    }
</style>

<script>
    import draggable from 'vuedraggable'
    import row from './Row.vue'
    import DeleteCategory from './DeleteCategory.vue'

    export default {
        components: {
            draggable,
            DeleteCategory,
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
                validated: false,
                modalVisible: false
            },
            editCategory: {
                id: '',
                name: '',
                validated: false,
                modalVisible: false
            }
        }),

        mounted() {
            this.loadSheet('/api/month');
        },

        methods: {
            refresh() {
                this.loadSheet('/api/month/' + this.month);
            },
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
                this.newCategory.modalVisible = true;
            },
            hideNewCategoryModal() {
                this.newCategory.modalVisible = false;
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
                this.editCategory.modalVisible = true;
            },
            hideEditCategoryModal() {
                this.editCategory.modalVisible = false;
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
            deleteCategory(category_id) {
                this.hideEditCategoryModal();
                this.$refs.deleteCategory.showModal(category_id);
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
            removeRow({id}) {
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