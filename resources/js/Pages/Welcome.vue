<template>
  <div>
    <template v-if="!$page.auth.user">
      <inertia-link href="/login">Login</inertia-link>
      <inertia-link href="/register">Register</inertia-link>
    </template>
    <template v-else>
      <inertia-link href="/logout" method="post">Logout</inertia-link>
    </template>
  </div>
</template>
