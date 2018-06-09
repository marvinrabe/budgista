<template>
    <div class="main">
        <app-toolbar :title="$t('title.settings')"/>

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

        <router-view></router-view>
    </div>
</template>

<script>
    import FontAwesomeIcon from '@fortawesome/vue-fontawesome'
    import faCog from '@fortawesome/fontawesome-free-solid/faCog'
    import faUserCircle from '@fortawesome/fontawesome-free-solid/faUserCircle'

    export default {
        components: {
            FontAwesomeIcon
        },
        computed: {
            tabs() {
                return [
                    {
                        label: 'title.general',
                        icon: faCog,
                        route: 'settings.general'
                    },
                    {
                        label: 'title.account',
                        icon: faUserCircle,
                        route: 'settings.account'
                    }
                ]
            }
        }
    }
</script>