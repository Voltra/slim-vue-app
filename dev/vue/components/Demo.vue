<template>
    <div class="demo">
        {{ str }}
    </div>
</template>

<script>
	export default {
		name: "demo",
        props: {
			str: {
				type: String,
                required: true
            }
        }
	}
</script>

<style lang="scss" scoped>
    .demo{
        background-color: aqua;
        color: green;
    }
</style>