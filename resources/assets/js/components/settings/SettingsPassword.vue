<template>
    <app-form @submit="save">
        <h5>Passwort ändern</h5>

        <form-group name="oldPassword">
            <app-password :disable-strength="true" slot-scope="{groupBindings}">
                <input class="form-control"
                       slot-scope="{bindings, handlers}"
                       v-bind="Object.assign(bindings, groupBindings)"
                       v-on="handlers"
                       v-validate.initial="'required'">
            </app-password>
        </form-group>

        <form-group name="newPassword">
            <app-password slot-scope="{groupBindings}">
                <input class="form-control"
                       slot-scope="{bindings, handlers}"
                       v-bind="Object.assign(bindings, groupBindings)"
                       v-on="handlers"
                       v-validate.initial="'required'">
            </app-password>
        </form-group>

        <div slot="actions">
            <button class="btn btn-text-light" type="reset">
                {{ $t('action.cancel') }}
            </button>

            <button class="btn btn-primary">
                {{ $t('action.settings.password') }}
            </button>
        </div>
    </app-form>
</template>