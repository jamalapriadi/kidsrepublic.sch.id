<template>
    <form @submit.prevent="store" action="data/post" method="post" enctype="multipart/form-data">
        <div class="row">
            <div class="col-lg-8">
                <div class="card card-flat">
                    <div class="card-header">Create News</div>
                    <div class="card-body">
                        <div class="form-group">
                            <label class="control-label">Title</label>
                            <input class="form-control" name="title" id="title" placeholder="Title" v-model="state.title">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Teaser</label>
                            <textarea name="teaser" id="teaser" cols="30" rows="3" class="form-control" v-model="state.teaser"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="" class="control-label">Date Event</label>
                            <datepicker :value="state.tanggal" :format="tanggalFormatter" v-model="state.tanggal"></datepicker>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Full Text</label>
                            <!-- <trumbowyg v-model="state.desc" class="form-control" name="content" :config="configText"></trumbowyg> -->
                            <textarea name="desc" id="desc" v-model="state.desc" cols="30" rows="10"></textarea>
                        </div>
                        <!-- <div class="form-group">
                            <label class="control-label">Youtube URL</label>
                            <input type="text" name="youtube" id="youtube" class="form-control" v-model="state.youtube">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Facebook URL</label>
                            <input type="text" name="facebook" id="facebook" class="form-control" v-model="state.facebook">
                        </div> -->

                        <!-- <div class="form-grou">
                            <label for="">Gallery Image</label>
                            <vue-upload-multiple-image
                                @upload-success="uploadImageSuccess"
                                @before-remove="beforeRemove"
                                @edit-image="editImage"
                                @data-change="dataChange"
                                :data-images="images"
                                :maxImage=20
                                dragText="Pilih Image"
                                browseText="Cari"
                                dropText="Drag n Drop"
                                markIsPrimaryText="Default Image"
                                primaryText="Primary Image"
                                ></vue-upload-multiple-image>
                        </div> -->
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card card-primary">
                    <div class="card-header">
                        <h6 class="card-title">Status</h6>
                    </div>
                    <div class="card-body">
                        <select name="status" id="status" class="form-control" v-model="state.status">
                            <option value="publish">Publish</option>
                            <option value="draft">Draft</option>
                            <option value="private">Private</option>
                        </select>
                    </div>  
                </div>

                <div class="card card-flat">
                    <div class="card-header">
                        Related News
                        <span class="float-right">
                            <a @click="showModal" href="#" class="btn btn-primary addnews">
                                <i class="icon-add"></i> Add News
                            </a>
                        </span>
                    </div>
                    <div class="card-body">
                        <table class='table table-striped' v-if="state.relatednews.length > 0">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(l,index) in state.relatednews" v-bind:key="index">
                                    <td>{{l.title}}</td>
                                    <td>
                                        <a class='btn btn-sm btn-danger text-white hapusrelatednews' @click="hapusrelatednews(l)">
                                            <i class='icon-trash'></i>
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- <div class="card card-flat">
                    <div class="card-header">
                        <h6 class="card-title">Category</h6>
                    </div>
                    <div class="card-body">
                        <multiselect v-model="state.categories" :options="categories" :multiple="true" 
                            :close-on-select="false" :clear-on-select="false" :preserve-search="true" 
                            placeholder="Pilih Category" label="text" track-by="text" :preselect-first="true">
                        </multiselect>
                        
                        <div id="showSubCategory"></div>
                    </div>  
                </div> -->

                <div class="card card-flat">
                    <div class="card-header">
                        <h6 class="card-title">Featured Image</h6>
                    </div>
                    <div class="card-body">

                        <div class="card card-default" v-show="showPreview">
                            <div class="card-header">Images Info</div>
                            <div class="card-body">
                                <img v-bind:src="state.file" class="img-fluid" v-bind:style="{ 'height': state.height+'px', 'width': state.width+'px', 'border-top-left-radius': state.border_radius.top_left+'px', 'border-top-right-radius': state.border_radius.top_right+'px', 'border-bottom-left-radius': state.border_radius.bottom_left+'px', 'border-bottom-right-radius': state.border_radius.bottom_right+'px'}">
                                
                                <br><br>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <fieldset>
                                            <div class="form-group">
                                                <label for="" class="control-label">Width</label>
                                                <div class="input-group">
                                                    <input type="number" class="form-control" v-model="state.width">
                                                    <span class="input-group-append">
                                                        <button class="btn btn-secondary" type="button">px</button>
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="" class="control-label">Height</label>
                                                <div class="input-group">
                                                    <input type="number" class="form-control" v-model="state.height">
                                                    <span class="input-group-append">
                                                        <button class="btn btn-secondary" type="button">px</button>
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="" class="control-label">Border Radius</label>
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <div class="input-group">
                                                            <span class="input-group-append">
                                                                <button class="btn btn-secondary" type="button">Top Left</button>
                                                            </span>
                                                            <input type="text" class="form-control" v-model="state.border_radius.top_left">
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6">
                                                        <div class="input-group">
                                                            <span class="input-group-append">
                                                                <button class="btn btn-secondary" type="button">Top Right</button>
                                                            </span>
                                                            <input type="text" class="form-control" v-model="state.border_radius.top_right">
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                            </div>

                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <div class="input-group">
                                                            <span class="input-group-append">
                                                                <button class="btn btn-secondary" type="button">Bottom</button>
                                                            </span>
                                                            <input type="text" class="form-control" v-model="state.border_radius.bottom_left">
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6">
                                                        <div class="input-group">
                                                            <span class="input-group-append">
                                                                <button class="btn btn-secondary" type="button">Bottom</button>
                                                            </span>
                                                            <input type="text" class="form-control" v-model="state.border_radius.bottom_right">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="" class="control-label">Alignment</label>
                                                <select name="alignment" id="alignment" v-model="state.alignment" class="form-control">
                                                    <option value="left">Left</option>
                                                    <option value="right">Right</option>
                                                    <option value="center">Center</option>
                                                </select>
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label">Choose File</label><br>
                                
                            <div class="input-group">
                                <input type="file" id="file" ref="file" accept="image/*" v-on:change="onFileChange" class="form-control"/>
                                <span class="input-group-addon" id="removeFeaturedImage">
                                    <i class=" icon-cross3"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card card-flat">
                    <div class="card-header">
                        Tags
                        <span class="float-right">
                            <a href="#" class="btn btn-primary header-btn" id="addtag">
                                <i class="icon-add"></i> Add Tag
                            </a>
                        </span>
                    </div>
                    <div class="card-body">
                        <!-- <span class="tag badge badge-dark" v-for="(k,index) in state.tags" v-bind:key="index">
                            <span>{{k.nama}}</span>
                            <a class="removetag">x</a>
                        </span> -->
                        <tags-input element-id="tags"
                            v-model="state.tags"
                            :typeahead="true">
                        </tags-input>
                    </div>
                </div>


            </div>

            <vue-loading v-if="loading" type="bars" color="#d9544e" :size="{ width: '50px', height: '50px' }"></vue-loading>    
            <div class="col-lg-12" v-if="message" v-bind:class="pesankelas">
                {{ message }}
            </div>

            <div class="col-lg-12">
                <div class="card card-flat">
                    <div class="card-body">
                        <div id="pesan"></div>

                        <router-link to="/all-post" class="btn btn-default">
                            <i class="icon-arrow-left7"></i> Back
                        </router-link>

                        <button class="btn btn-primary float-right">
                            <i class="icon-floppy-disk"></i>
                            Save
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <b-modal ref="myModalRef" size="lg" id="modal-1" title="Related News">
            <div class="row">
                <div class="col-lg-5">
                    <form class="form-inline">
                        <div class="form-group">
                            <label for="" class="control-label col-lg-4">FILTER:</label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" name="q" id="q" placeholder="Type and Enter" v-model="pencarian">
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Author</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(l,index) in relatednews.data" v-bind:key="index">
                        <td>
                            <input type="checkbox" v-model="pilihrelatednews[index]" v-bind:value="l" @click="pilihnews(l,$event)">
                        </td>
                        <td>{{l.title}}</td>
                        <td>{{l.penulis.name}}</td>
                    </tr>
                </tbody>
            </table>

            <div align="right">
                <!-- <pagination :data="relatednews" @pagination-change-page="showRelatedNews" :show-disabled="true"></pagination> -->
            </div>
        </b-modal>


    </form>
</template>

<script>
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
import { VueLoading } from 'vue-loading-template'
import Multiselect from 'vue-multiselect'
import VueUploadMultipleImage from 'vue-upload-multiple-image'

import Trumbowyg from 'vue-trumbowyg';
import moment from 'moment'
import Datepicker from 'vuejs-datepicker';
  
// Import editor css
import 'trumbowyg/dist/ui/trumbowyg.css';
import 'trumbowyg/plugins/fontsize/trumbowyg.fontsize';
import 'trumbowyg/plugins/fontfamily/trumbowyg.fontfamily';

export default {
    components: {
        VueLoading,
        VoerroTagsInput,
        Multiselect,
        VueUploadMultipleImage,
        Datepicker,
        Trumbowyg
    },
    data(){
        return {
            state:{
                title:'',
                topik:'',
                teaser:'',
                desc:'',
                youtube:'',
                tanggal: '',
                file:'',
                facebook:'',
                category:'',
                status:'publish',
                relatednews:[],
                categories:[],
                subcategory:[],
                tags: [],
                images:[],
                height:770,
                width:384,
                border_radius:{
                    top_left:0,
                    top_right:0,
                    bottom_left:0,
                    bottom_right:0
                },
                alignment:'left'
            },
            pencarian:'',
            pesankelas:'',
            message:'',
            loading:false,
            editor: ClassicEditor,
            editorConfig: {
                // The configuration of the editor.
            },
            categories:[],
            relatednews:[],
            pilihrelatednews:[],
            showPreview: false,
            imagePreview: '',
            tag: '',
            selectedTags : '',
            images:[],
            maxImage:10,
            configText:{
                btns: [
                    ['viewHTML'],
                    ['fontfamily'],
                    ['fontsize'],
                    ['undo', 'redo'], // Only supported in Blink browsers
                    ['formatting'],
                    ['strong', 'em', 'del'],
                    ['superscript', 'subscript'],
                    ['link'],
                    ['insertImage'],
                    ['justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull'],
                    ['unorderedList', 'orderedList'],
                    ['horizontalRule'],
                    ['removeformat'],
                    ['fullscreen'],
                ],
                plugins: {
                    fontsize: {
                        sizeList: [
                            '5px',
                            '9px',
                            '10px',
                            '11px',
                            '12px',
                            '14px',
                            '16px',
                            '18px',
                            '20px',
                            '22px',
                            '24px',
                            '26px',
                            '28px',
                            '36px',
                            '48px',
                        ],
                        allowCustomSize: false
                    }
                },
                autogrow: true,
                changeActiveDropdownIcon: true
            }
            // selectedTags: { 
            //     1: 'Web Development',
            //     2: 'PHP',
            //     3: 'JavaScript',
            // },
        }
    },
    mounted() {
        this.getCategory();
        this.getTag();
        this.getCKeditor();
    },
    watch: {
        pencarian: function(q) {
            if (q != ''){
                this.cariRelatedNews();
            }else{
                this.showRelatedNews();
            }
        }
    },
    methods:{
        tanggalFormatter(date) {
            return moment(date).format('YYYY-MM-DD');
        },

        getCategory(){
            axios.get('data/list-category')
                .then(response => {
                    this.categories = response.data;
                })  
        },

        getCKeditor(){
            CKEDITOR.replace( 'desc',{
                extraPlugins : ['btgrid','wenzgmap','bootstrapTabs','link'],
                language: 'en',
                allowedContent: true,
                entities: false,
                enterMode:2,forceEnterMode:false,shiftEnterMode:1,
                toolbar :
                    [
                        [ 'Font', 'FontSize','Styles' ],        
                        [ 'Bold', 'Italic', 'Underline'],
                        [ 'Image', 'Table', 'HorizontalRule', 'SpecialChar' ],
                        ['TextColor','BGColor'],
                        [ 'Paste', 'PasteText', 'PasteFromWord'],
                        '/',
                        [ 'NumberedList', 'BulletedList', '-','JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock'],
                        [ 'Link','Anchor','btgrid','About','wenzgmap','BootstrapTabs','Source','Maximize'],
                    ],
                toolbarGroupsCanCollapse:true,
                filebrowserBrowseUrl: 'ckfinder/ckfinder.html',
                filebrowserWindowWidth: '1000',
                filebrowserWindowHeight: '700'
            });

            // CKFinder.setupCKEditor( editor );
        },

        getTag(){
            axios.get('data/list-tags')
                .then(response=>{
                    this.selectedTags=response.data.toString();
                    // for(var a=0;a.response.data.length; a++){
                    //     this.selectedTags.push(response.data[a].text);
                    // }
                })
            console.log(this.selectedTags);
        },

        showModal () {
            this.$refs.myModalRef.show()
            this.showRelatedNews();
        },

        showRelatedNews(){
            axios.get('data/list-post?type=artikel')
                .then(response => {
                    this.relatednews = response.data;
                    console.log(this.relatednews);
                })
        },

        cariRelatedNews(page){
            if(typeof page === 'undefined'){
                page = 1;
            }

            axios.get('data/list-post?type=artikel&q='+this.pencarian)
                .then(response => {
                    this.relatednews = response.data;
                })
                .catch( errors => {
                    alert('pencarian tidak ditemukan');
                })
        },

        pilihnews(l, event){
            if (event.target.checked) {
                this.state.relatednews.push(l);
            }else{
                this.state.relatednews.splice(l, 1);
            }

            console.log(this.state.relatednews);
        },
        
        hapusrelatednews(l){
            this.state.relatednews.splice(l, 1);
        },

        onFileChange(e) {
            let file = this.$refs.file.files[0];
            if(!file || file.type.indexOf('image/') !== 0) return;
            
            let reader = new FileReader();
            
            reader.readAsDataURL(file);
            reader.onload = evt => {
                let img = new Image();
                img.onload = () => {
                    this.state.width = img.width
                    this.state.height = img.height
                    console.log(img.width+' - '+img.height)
                }
                img.src = evt.target.result;
            }

            let files = e.target.files || e.dataTransfer.files;
            if (!files.length)
                return;

            let ukuran = files[0].size;

            if(ukuran > 1000000){
                this.$swal('Warning', 'Ukuran file image tidak boleh lebih dari 1 MB' , 'warning');
                return;
            }

            if(files[0]['type']==='image/jpeg' || files[0]['type']==='image/png' || files[0]['type']==='image/jpg'){
                this.createImage(files[0]);
            }else{
                this.$swal('Warning', 'Format file tidak diketahui' , 'warning');
                return;
            }
        },
        
        createImage(file) {
            let reader = new FileReader();
            let vm = this;
            reader.onload = (e) => {
                vm.state.file = e.target.result;
                vm.showPreview = true;
            };
            reader.readAsDataURL(file);
        },

        store(e,) {
            this.loading=true;
            this.state.desc = CKEDITOR.instances.desc.getData();


            axios.post(e.target.action, this.state).then(response => {
                this.loading=false;
                if(response.data.success==true){
                    this.errors = [];
                    this.state={
                        title:'',
                        topik:'',
                        teaser:'',
                        desc:'',
                        youtube:'',
                        file:'',
                        youtube:'',
                        facebook:'',
                        status:'publish',
                        relatednews:[],
                        category:[],
                        subcategory:[],
                        tags:[],
                        images:[],
                        height:770,
                        width:384,
                        border_radius:{
                            top_left:0,
                            top_right:0,
                            bottom_left:0,
                            bottom_right:0
                        },
                        alignment:'left'
                    },
                    this.showPreview=false
                    this.message = 'Data has been saved.';
                    this.pesankelas='alert alert-success';
                }else{
                    this.pesankelas='alert alert-danger';
                    this.message = response.data.errors;
                    this.errors.nama=true;
                }
            }).catch(error => {
                if (! _.isEmpty(error.response)) {
                    if (error.response.status = 422) {
                        this.errors = error.response.data;
                        console.log(this.errors);
                    }
                }
            });
        },

        uploadImageSuccess(formData, index, fileList) {
            console.log('data', formData, index, fileList)
            this.state.images.push(fileList[index]);
            // Upload image api
            // axios.post('data/post', { data: formData }).then(response => {
            //   console.log(response)
            // })
        },
        beforeRemove (index, done, fileList) {
            console.log('index', index, fileList)
            var r = confirm("remove image")
            if (r == true) {
                done()
            } else {

            }
        },
        editImage (formData, index, fileList) {
            console.log('edit data', formData, index, fileList)
        },
        dataChange (data) {
            console.log(data)
        }
    }
}
</script>


<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
<style>
    /* adapted from http://maxwells.github.io/bootstrap-tags.html */
    .ck-editor__editable {
        min-height: 400px;
    }

    /* The input */
    .tags-input {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
    }

    .tags-input input {
        flex: 1;
        background: transparent;
        border: none;
    }

    .tags-input input:focus {
        outline: none;
    }

    .tags-input input[type="text"] {
        color: #495057;
    }

    .tags-input-wrapper-default {
        padding: .5rem .25rem;

        background: #fff;

        border: 1px solid transparent;
        border-radius: .25rem;
        border-color: #dbdbdb;
    }

    /* The tag badges & the remove icon */
    .tags-input span {
        margin-right: 0.3rem;
    }

    .tags-input-remove {
        cursor: pointer;
        position: relative;
        display: inline-block;
        width: 0.5rem;
        height: 0.5rem;
        overflow: hidden;
    }

    .tags-input-remove:before, .tags-input-remove:after {
        content: '';
        position: absolute;
        width: 100%;
        top: 50%;
        left: 0;
        background: #5dc282;
        
        height: 2px;
        margin-top: -1px;
    }

    .tags-input-remove:before {
        transform: rotate(45deg);
    }
    .tags-input-remove:after {
        transform: rotate(-45deg);
    }

    /* Tag badge styles */
    .tags-input-badge {
        display: inline-block;
        padding: 0.25em 0.4em;
        font-size: 75%;
        font-weight: 700;
        line-height: 1;
        text-align: center;
        white-space: nowrap;
        vertical-align: baseline;
        border-radius: 0.25rem;
    }

    .tags-input-badge-pill {
        padding-right: 0.6em;
        padding-left: 0.6em;
        border-radius: 10rem;
    }

    .tags-input-badge-selected-default {
        color: #212529;
        background-color: #f0f1f2;
    }

    /* Typeahead - badges */
    .typeahead-badges > span {
        cursor: pointer;
        margin-right: 0.3rem;
    }

    /* Typeahead - dropdown */
    .typeahead-dropdown {
        list-style-type: none;
        padding: 0;
        margin: 0;
        position: absolute;
        width: 100%;
    }

    .typeahead-dropdown li {
        padding: .25rem 1rem;
        cursor: pointer;
    }

    /* Typeahead elements style/theme */
    .tags-input-typeahead-item-default {
        color: #fff;
        background-color: #343a40;
    }

    .tags-input-typeahead-item-highlighted-default {
        color: #fff;
        background-color: #007bff;
    }

    #my-strictly-unique-vue-upload-multiple-image {
        font-family: 'Avenir', Helvetica, Arial, sans-serif;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        text-align: center;
        color: #2c3e50;
        margin-top: 60px;
    }

    h1, h2 {
        font-weight: normal;
    }

    ul {
        list-style-type: none;
        padding: 0;
    }

    li {
        display: inline-block;
        margin: 0 10px;
    }

    a {
        color: #42b983;
    }
</style>

