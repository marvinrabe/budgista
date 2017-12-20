<template>
    <div class="main">
        <app-toolbar :title="$t('title.settings')" />

        <div class="container-fluid mt-2">
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <router-link
                            class="nav-link"
                            :to="{ name: 'settings.account' }"
                            active-class="active"
                            :exact="true">
                        <font-awesome-icon :icon="['far', 'user-circle']" fixed-width class="mr-1"/>
                        {{ $t('title.account') }}
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link
                            class="nav-link"
                            :to="{ name: 'settings.security' }"
                            active-class="active">
                        <font-awesome-icon icon="shield-alt" fixed-width class="mr-1"/>
                        {{ $t('title.security') }}
                    </router-link>
                </li>
            </ul>
        </div>

        <router-view></router-view>
    </div>
</template>

<script>
    export default {

    }
</script>