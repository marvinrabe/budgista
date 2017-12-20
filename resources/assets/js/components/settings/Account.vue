<template>
    <div class="content container-fluid">
        <div class="row justify-content-center">
            <div class="col mt-3 col-lg-8">
                <form class="p-2" novalidate>
                    <h5>Allgemeines</h5>

                    <div class="form-group">
                        <label for="test">{{ $t('form.payee')}}</label>
                        <input id="test" type="text" class="form-control"
                               v-validate.initial="'required'"
                               data-vv-name="test"
                               :data-vv-as="$t('form.payee')">
                        <span class="invalid-feedback">{{ errors.first('test') }}</span>
                    </div>

                    <div class="text-right">
                        <button class="btn btn-text-light" type="reset">
                            {{ $t('action.cancel') }}
                        </button>

                        <button class="btn btn-primary">
                            {{ $t('action.save') }}
                        </button>
                    </div>

                </form>
            </div>
            <div class="w-100"></div>
            <div class="col mt-3 col-lg-8">
                <form class="p-2" novalidate>
                    <h5>E-Mail Adresse ändern</h5>

                    <div class="form-group">
                        <label for="payee">{{ $t('form.payee')}}</label>
                        <input id="payee" type="text" class="form-control"
                               v-validate.initial="'required'"
                               data-vv-name="payee"
                               :data-vv-as="$t('form.payee')">
                        <span class="invalid-feedback">{{ errors.first('payee') }}</span>
                    </div>

                    <div class="text-right">
                        <button class="btn btn-text-light" type="reset">
                            {{ $t('action.cancel') }}
                        </button>

                        <button class="btn btn-primary">
                            {{ $t('action.save') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    export default {}
</script>