<template>
    <div class="main">
        <app-toolbar :title="$t('title.settings')"/>

        <div class="container-fluid mt-2">
            <ul class="nav nav-tabs">
                <li class="nav-item" v-for="tab in tabs">
                    <router-link
                            class="nav-link"
                            :to="{ name: tab.route }"
                            active-class="active"
                            :exact="true">
                        <font-awesome-icon :icon="tab.icon" fixed-width class="mr-1"/>
                        {{ $t(tab.label) }}
                    </router-link>
                </li>
            </ul>
        </div>

        <router-view></router-view>
    </div>
</template>

<script>
    import FontAwesomeIcon from '@fortawesome/vue-fontawesome'
    import faUserCircle from '@fortawesome/fontawesome-free-regular/faUserCircle'
    import faShieldAlt from '@fortawesome/fontawesome-free-solid/faShieldAlt'

    export default {
        components: {
            FontAwesomeIcon
        },
        computed: {
            tabs() {
                return [
                    {
                        label: 'title.account',
                        icon: faUserCircle,
                        route: 'settings.account'
                    },
                    {
                        label: 'title.security',
                        icon: faShieldAlt,
                        route: 'settings.security'
                    }
                ];
            }
        }
    }
</script>