<template>
    <div class="container">
        <div class="input-group form-group">
            <button v-on:click="sendRating()" class="btn btn-outline-dark">Geef dit project een rating</button>
            <input v-model="userRating" class="form-control">
        </div>
    </div>
</template>

<script>
    import axios from 'axios';

    export default{
        name: 'RatingComponent',
        props:{
            project:{
                type: String,
                default: 0
            }
        },
        data(){
            return{
                userRating: 0,
            }
        },
        created: function(){
            axios.get("/projects/"+ this.project + "/rate/")
                .then((response)  =>  {
                    this.userRating = response.data;
                    console.log(this.rating)
            })
        },
        methods:{
            sendRating: function(){
                axios.get("/projects/"+ this.project + "/rate/"+this.userRating)
                    .then((response)  =>  {
                        this.userRating = response.data;
                        console.log(this.userRating)
                })
            }
        }
    }
</script>
