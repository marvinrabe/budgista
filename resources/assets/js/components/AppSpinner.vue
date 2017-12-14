<template>
    <div class="spinner" role="progressbar" :aria-label="$t('action.loading')">
        <div class="bounce1"></div>
        <div class="bounce2"></div>
        <div class="bounce3"></div>
    </div>
</template>

<style>
    .spinner {
        padding: 1em 0;
        margin: 0 auto;
        width: 70px;
        text-align: center;
        opacity: .5;
    }

    .spinner > div {
        width: 13px;
        height: 13px;
        background-color: #000;
        opacity: .8;

        border-radius: 100%;
        display: inline-block;
        animation: sk-bouncedelay 1.4s infinite ease-in-out both;
    }

    .spinner .bounce1 {
        animation-delay: -0.32s;
    }

    .spinner .bounce2 {
        animation-delay: -0.16s;
    }

    @keyframes sk-bouncedelay {
        0%, 80%, 100% { 
            transform: scale(0);
        } 40% { 
            transform: scale(1.0);
        }
    }
</style>