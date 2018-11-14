<script>
    import {TbSkeleton} from 'tb-skeleton'

    export default {
        props: {
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
        render(createElement) {
            if (!this.busy) {
                return this.$slots.default[0]
            }

            return createElement(TbSkeleton, {
                style: {
                    height: this.height,
                    width: this.width,
                    backgroundColor: 'rgba(0, 0, 0, 10%)'
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
