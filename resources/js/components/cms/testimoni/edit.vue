<template>
    <form v-on:submit.prevent="saveForm()" enctype="multipart/form-data">
        <div class="row">
            <div class="col-lg-8">
                <div class="card card-flat">
                    <div class="card-header">Edit Testimoni</div>
                    <div class="card-body">
                        <div class="form-group">
                            <label class="control-label">Title</label>
                            <input class="form-control" name="title" id="title" placeholder="Title" v-model="state.title">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Description</label>
                            <!-- <trumbowyg v-model="state.desc" class="form-control" :config="configText" name="content"></trumbowyg> -->
                            <textarea name="desc" id="desc" v-model="state.desc" cols="30" rows="10"></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                
                <div class="card card-flat">
                    <div class="card-header">
                        <h6 class="card-title">Featured Image</h6>
                    </div>
                    <div class="card-body">
                        <div class="card card-default" v-show="showPreview">
                            <div class="card-header">Images Info</div>
                            <div class="card-body">
                                <img v-bind:src="state.tmp_file" class="img-fluid" v-bind:style="{ 'height': state.height+'px', 'width': state.width+'px', 'border-top-left-radius': state.border_radius.top_left+'px', 'border-top-right-radius': state.border_radius.top_right+'px', 'border-bottom-left-radius': state.border_radius.bottom_left+'px', 'border-bottom-right-radius': state.border_radius.bottom_right+'px'}">
                                
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

            </div>

            <vue-loading v-if="loading" type="bars" color="#d9544e" :size="{ width: '50px', height: '50px' }"></vue-loading>    
            <div class="col-lg-12" v-if="message" v-bind:class="pesankelas">
                {{ message }}
            </div>

            <div class="col-lg-12">
                <div class="card card-flat">
                    <div class="card-body">
                        <div id="pesan"></div>

                        <router-link to="/testimoni" class="btn btn-default">
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

        

    </form>
</template>

<script>
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
import { VueLoading } from 'vue-loading-template'
import Multiselect from 'vue-multiselect'
import Datepicker from 'vuejs-datepicker';
import moment from 'moment'
import Timeselector from 'vue-timeselector';

import Trumbowyg from 'vue-trumbowyg';
  
// Import editor css
import 'trumbowyg/dist/ui/trumbowyg.css';
import 'trumbowyg/plugins/fontsize/trumbowyg.fontsize';
import 'trumbowyg/plugins/fontfamily/trumbowyg.fontfamily';

export default {
    components: {
        VueLoading,
        VoerroTagsInput,
        Multiselect,
        Datepicker,
        Timeselector,
        Trumbowyg
    },
    data(){
        return {
            postId:'',
            state:{
                title:'',
                topik:'',
                teaser:'',
                desc:'',
                file:'',
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
            showPreview: false,
            tmpshowPreview:false,
            imagePreview: '',
            tag: '',
            selectedTags:{},
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
        }
    },
    mounted() {
        // this.getCategory();
        this.getData();
    },
    methods:{
        getData(){
            let app=this;
            let id= app.$route.params.id;
            this.postId = id;

            axios.get('data/post/'+id)
                .then(response => {
                    this.state.title=response.data.title;
                    this.state.topik=response.data.topik;
                    this.state.desc=response.data.description;
                    this.state.file="";
                    
                    if(response.data.featured_image!=null){
                        this.state.tmp_file=response.data.feature_image_url;
                        this.showPreview=true;
                    }

                    this.state.width = response.data.image_width;
                    this.state.height = response.data.image_height;
                    this.state.alignment = response.data.image_alignment;
                    this.state.border_radius={
                        top_left: response.data.image_border_top_left_radius,
                        top_right: response.data.image_border_top_right_radius,
                        bottom_left: response.data.image_border_bottom_left_radius,
                        bottom_right: response.data.image_border_bottom_right_radius
                    }

                    this.getCKeditor()
                })
                .catch( error => {
                    alert('data tidak dapat di load');
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
            this.createImage(files[0]);
        },
        createImage(file) {
            let reader = new FileReader();
            let vm = this;
            reader.onload = (e) => {
                vm.state.file = e.target.result;
                vm.state.tmp_file = e.target.result;
                vm.showPreview = true;
            };
            reader.readAsDataURL(file);
        },

        saveForm(){
            this.loading=true;
            this.state.desc = CKEDITOR.instances.desc.getData();

            axios.patch('data/testimoni/'+this.postId, this.state)
                .then(response => {
                    this.loading=false;
                    if(response.data.success==true){
                        this.errors = [];
                        // this.state={
                        //     title:'',
                        //     topik:'',
                        //     teaser:'',
                        //     desc:'',
                        //     youtube:'',
                        //     file:'',
                        //     facebook:'',
                        //     status:'publish',
                        //     relatednews:[],
                        //     category:[],
                        //     subcategory:[],
                        //     tags:[]
                        // },
                        this.message = 'Data has been saved.';
                        this.pesankelas='alert alert-success';
                        // this.$router.replace('/all-post');
                    }else{
                        this.pesankelas='alert alert-danger';
                        this.message = response.data.errors;
                        this.errors.nama=true;
                    }
                })
                .catch( error => {
                    alert('data gagal diupdate');
                })
        },
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
</style>

