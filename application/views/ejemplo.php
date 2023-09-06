<!-- Aqui se ocupa la parte de Html como si fueran las etiquetas template de vue -->
<h1>{{message}}</h1>
<!-- Aqui se agrega la parta de Vue si es que se ucopa -->
<script>
        const { createApp, ref } = Vue

        createApp({
            setup() {
            const message = ref('Hello vue!')
            return {
                message
            }
            }
        }).mount('#app')
    
</script>