<template>
    <component :is="$route.meta.layout" >
        <router-view></router-view>
    </component>
</template>

<script>
import { onMounted } from 'vue';
import { useRouter, useRoute } from 'vue-router';

export default {
    setup() {
        const route = useRoute()
        const router = useRouter()

        onMounted(() => {
            if(!localStorage.getItem('userSession') && route.path != '/attendances' )
            {
                const redirect = route.query.redirect || '/'
                router.push(redirect)
            }
        })
    },
}
</script>
