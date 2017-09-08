<template>
    <div id="layout">
        <div class="menu">
            <div class="app-menu">

                <nav class="navbar navbar-expand navbar-light">
                    <a class="navbar-brand logo" href="/">
                        {{ $t('app.name') }}
                    </a>

                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item d-md-none">
                            <a href="#" class="menu-toggle nav-link">
                                <span class="fa fa-times"></span>
                            </a>
                        </li>
                    </ul>
                </nav>

                <nav class="nav flex-column">
                    <router-link
                            :to="{ name: 'budget.month', params: { budget: budget_id }}"
                            active-class="active" :exact="true" class="nav-link-main">
                        <span class="fa fa-envelope-o fa-fw"></span> {{ $t('title.budget') }}
                    </router-link>
                    <h6 class="nav-header">Accounts</h6>
                    <router-link
                            v-for="account in accounts" :key="account.id"
                            :to="{ name: 'budget.account', params: { account_id: account.id }}"
                            active-class="active" class="nav-link-main">
                        <span
                                class="float-right mt-1 badge"
                                :class="[{ 'badge-danger': account.workingBalance < 0 }, { 'badge-success': account.workingBalance >= 0 }]">
                            {{ account.workingBalance }}
                        </span>
                        {{ account.name }}
                    </router-link>
                    <a href="" class="nav-link text-muted small text-right">
                        <span class="fa fa-plus"></span> {{ $t('action.new.account') }}
                    </a>
                </nav>

            </div>
        </div>

        <transition name="fade" mode="out-in">
            <keep-alive>
                <router-view></router-view>
            </keep-alive>
        </transition>
    </div>
</template>

<script>
    export default {
        props: ['budget_id'],
        data: () => ({
            'accounts': []
        }),
        created: function () {
            axios
                .get('/api/budgets/' + this.budget_id + '/accounts')
                .then(response => {
                    this.accounts = response.data.data;
                })
                .catch(e => {
                    this.errors.push(e)
                });
        }
    }
</script>