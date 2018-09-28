<template>
    <div class="container">
        <div class="input-group form-group">
            <button v-on:click="sendRating()" class="btn btn-outline-dark">Rate this project:</button>
            <input type="number" v-model="rating" class="form-control">
        </div>
    </div>
</template>

<script>
    export default{
        name: 'RatingComponent',
        data(){
            return{
                rating: 0
            }
        },
        methods:{
            sendRating: function(){
                console.log(this.rating)
            }
        }
    }
</script>
