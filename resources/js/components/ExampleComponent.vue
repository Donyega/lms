<template>
    <div class="container">
        <div class="d-flex align-items-center card-congratulations">
            <div class="avatar-lecture">
                <img src="" width="100%">
            </div>
            <div class="col">
                <div class="row justify-content-between align-items-center">
                    <div class="col-lg-9 text">
                        <span>Nama</span>
                        <span class="d-block font-small-2">xxx</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="dropdown-divider"></div>
    </div>
</template>

<script>
    export default {
          data(){
            return{
                diskusi:{}
            }
        },
        methods:{
            getDataDiskusi(){
                axios.get(`api/getdiskusi/1`).then(({data}) => (this.diskusi = data))
            }
        },
        created() {
            // let uri = window.location.href
            // uri = uri.split("/");
            // // let params = new URLSearchParams(uri);
            console.log(data);
            this.getDataDiskusi()
        },

    }
</script>
