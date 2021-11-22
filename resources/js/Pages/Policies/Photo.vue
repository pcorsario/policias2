<template>
    <el-upload
        class="avatar-uploader"
        :auto-upload="false"
        ref="photo"
        :action="route('front.policia.update.photo')"
        :with-credentials="true"
        :data="{'_token': $page.props.csrf}"
        :on-change="cargarImagen"
        :show-file-list="false"
        :on-success="handleAvatarSuccess"
        :thumbnail-mode="true"
        :before-upload="beforeAvatarUpload">
        <img v-if="imageUrl" :src="imageUrl" class="avatar">
        <div v-else class="avatar-uploader-icon">
            <span>Seleccione una foto</span>
        </div>
    </el-upload>
    <div v-if="imageUrl">
        <el-button type="primary" size="small" @click="subirFoto">Actualizar foto</el-button>
    </div>
</template>

<script>
export default {
    name: "Photo",

    data(){
        return {
            imageUrl: '',
        }
    },

    mounted(){
    },

    methods: {
        handleAvatarSuccess(res, file){
            this.imageUrl = URL.createObjectURL(file.raw);
            console.log(this.imageUrl);
        },

        beforeAvatarUpload(file){
            console.log(file);
        },

        cargarImagen(file){
            this.imageUrl = URL.createObjectURL(file.raw);
        },

        subirFoto(){
            this.$refs.photo.submit();
        }
    }
}
</script>

<style>
.avatar-uploader .el-upload {
    border: 1px dashed #d9d9d9;
    border-radius: 6px;
    cursor: pointer;
    position: relative;
    overflow: hidden;
}
.avatar-uploader .el-upload:hover {
    border-color: #409EFF;
}
.avatar-uploader-icon {
    font-size: 0.7rem;
    color: #8c939d;
    width: 178px;
    height: 178px;
    line-height: 178px;
    text-align: center;
}
.avatar {
    width: 178px;
    height: 178px;
    display: block;
}
</style>
