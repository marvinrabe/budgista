<template>
    <div class="d-flex">
        <router-link
                :to="{ name: 'budget', params: {month: month.previous().toString()} }"
                class="text-secondary align-self-center small"
                :title="$t('action.previousMonth')">
            <font-awesome-icon :icon="previousIcon"/>
        </router-link>
        <span class="mx-1">
            {{ month.format() }}
        </span>
        <router-link
                :to="{ name: 'budget', params: {month: month.next().toString()} }"
                class="text-secondary align-self-center small"
                :title="$t('action.nextMonth')">
            <font-awesome-icon :icon="nextIcon"/>
        </router-link>
    </div>
</template>


<script>
    import Month from '../../models/Month'
    import FontAwesomeIcon from '@fortawesome/vue-fontawesome'
    import faChevronLeft from '@fortawesome/fontawesome-free-solid/faChevronLeft'
    import faChevronRight from '@fortawesome/fontawesome-free-solid/faChevronRight'

    export default {
        props: {
            month: {
                type: Month
            }
        },
        components: {
            FontAwesomeIcon
        },
        computed: {
            previousIcon() {
                return faChevronLeft;
            },
            nextIcon() {
                return faChevronRight;
            }
        }
    }
</script>