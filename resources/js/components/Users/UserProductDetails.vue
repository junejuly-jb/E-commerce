<template>
    <v-app>
        {{ id }}
    </v-app>
</template>
<script>
export default {
    data(){
        return{
            id: this.$route.params.id
        }
    }
}
</script>