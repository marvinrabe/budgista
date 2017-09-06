<template>
    <div>

        <div class="float-right my-3 ml-4 btn-group">
            <button class="btn btn-light" :title="$t('action.edit.account')">
                <span class="fa fa-cog"></span>
            </button>
            <button class="btn btn-primary">
                <span class="fa fa-plus"></span> {{ $t('action.new.transaction') }}
            </button>
        </div>

        <p class="display-4">
            {{ account.name }}
        </p>

        <div class="form-row text-center">
            <div class="col">
                <strong class="">
                    {{ $formatNumber(0, {style: 'currency', currency: currency}) }}
                </strong>
                <p class="small">{{ $t('form.balance.cleared') }}</p>
            </div>
            <div class="col">
                <strong class="">
                    {{ $formatNumber(0, {style: 'currency', currency: currency}) }}
                </strong>
                <p class="small">{{ $t('form.balance.uncleared') }}</p>
            </div>
            <div class="col">
                <strong class="">
                    {{ $formatNumber(0, {style: 'currency', currency: currency}) }}
                </strong>
                <p class="small">{{ $t('form.balance.working') }}</p>
            </div>
        </div>

        <table class="table table-sm">
            <thead>
            <tr>
                <th width="32"></th>
                <th>{{ $t('form.date') }}</th>
                <th>{{ $t('form.payee') }}</th>
                <th>{{ $t('form.category') }}</th>
                <th>{{ $t('form.memo') }}</th>
                <th class="text-right">{{ $t('form.outflow') }}</th>
                <th class="text-right">{{ $t('form.inflow') }}</th>
                <th></th>
            </tr>
            </thead>
            <tr class="text-muted bg-light">
                <td>
                    <button class="btn btn-xs btn-light">
                        <span class="fa fa-check"></span>
                    </button>
                </td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td class="text-danger text-right">
                    - 0
                </td>
                <td class="text-success text-right">
                    + 0
                </td>
                <td>
                    <a href="" :title="$t('action.edit.transaction')" class="text-muted">
                        <span class="fa fa-pencil"></span>
                    </a>
                </td>
            </tr>
        </table>
    </div>
</template>

<script>
    export default {
        props: ['account_id'],
        computed: {
            currency: function () {
                return window.currency;
            }
        },
        data: () => ({
            account: null,
            transactions: []
        }),
        created: function () {
            axios
                .get('/api/accounts/'+this.account_id)
                .then(response => {
                    // JSON responses are automatically parsed.
                    this.account = response.data;
                })
                .catch(e => {
                    this.errors.push(e)
                });
        },
        methods: {

        }

    }
</script>