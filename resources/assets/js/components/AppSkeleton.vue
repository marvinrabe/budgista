<script>
    import {TbSkeleton} from 'tb-skeleton'

    export default {
        props: {
            variant: {
                default: 'light'
            },
            busy: {
                default: false
            },
            width: {
                default: '66%'
            },
            height: {
                default: '1.25em'
            }
        },
        computed: {
            classes() {
                return ['c-skeleton__tb--color-' + this.variant]
            }
        },
        render(createElement) {
            if (!this.busy) {
                return this.$slots.default[0]
            }

            return createElement(TbSkeleton, {
                'class': this.classes,
                style: {
                    height: this.height,
                    width: this.width
                },
                props: {
                    theme: 'opacity',
                    shape: 'radius',
                    duration: '1'
                }
            })
        }
    }
</script>
