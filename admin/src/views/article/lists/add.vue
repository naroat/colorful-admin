<template>
  <div>
    <p v-if="id > 0" class="menu_name">更新文章</p>
    <p v-else class="menu_name">添加文章</p>
    <el-form ref="ruleForm" :model="ruleForm" status-icon :rules="rules" label-width="100px" class="demo-ruleForm">
      <el-form-item label="标题" prop="title" style="width:600px;">
        <el-input v-model="ruleForm.title" type="text" />
      </el-form-item>
      <el-form-item label="描述" prop="desc" style="width:600px;">
        <el-input v-model="ruleForm.desc" type="textarea" rows="4" />
      </el-form-item>
      <el-form-item label="分类" prop="categorys">
        <el-select
          v-model="ruleForm.cat_id"
          placeholder="请选择分类"
        >
          <el-option
            v-for="item in categorys_arr"
            :key="item.id"
            :label="item.name"
            :value="item.id"
          />
        </el-select>
      </el-form-item>
      <el-form-item label="标签" prop="tags">
        <el-select
          v-model="ruleForm.tags"
          multiple
          filterable
          allow-create
          default-first-option
          placeholder="请选择标签"
        >
          <el-option
            v-for="item in tags_arr"
            :key="item.value"
            :label="item.label"
            :value="item.value"
          />
        </el-select>
      </el-form-item>
      <el-form-item label="是否显示" prop="is_show">
        <el-switch
          v-model="ruleForm.is_show"
          active-value="1"
          inactive-value="0"
          active-color="#13ce66"
          inactive-color="#ff4949"
        />
      </el-form-item>
      <el-form-item label="内容" prop="content">
        <mavon-editor
          ref="md"
          v-model="ruleForm.content"
          @imgAdd="imgAdd"
          @imgDel="imgDel"
        />
      </el-form-item>
      <el-form-item>
        <el-button type="primary" @click="submitForm('ruleForm')">提交</el-button>
      </el-form-item>
    </el-form>
  </div>
</template>
<style>
.menu_name{
    padding-left: 15px;
    font-weight: 600;
    font-size: 24px;
}
.t-mr10{
    margin-right: 10px;
}
</style>
<script>
import Vue from 'vue'
import { add, getOne, update, getCategoryList } from '@/api/article'
import { uploadBase64 } from '@/api/upload'
import { getToken } from '../../../utils/auth'
import { mavonEditor } from 'mavon-editor'
import 'mavon-editor/dist/css/index.css'
Vue.use(mavonEditor)

export default {
  components: { mavonEditor },

  data() {
    return {
      id: this.$route.query.id,
      tags_value: [],
      tags_arr: [],
      cat_id: '',
      categorys_arr: [],
      tableData: [],
      ruleForm: {},
      rules: {
        title: [
          { validator: validateTitle, trigger: 'blur' }
        ],
        categorys: [
          { validator: validateCategorys, trigger: 'blur' }
        ],
        tags: [
          { validator: validateTags, trigger: 'blur' }
        ],
        content: [
          { validator: validateContent, trigger: 'blur' }
        ]
      }
    }
    var validateTitle = (rule, value, callback) => {
      if (value === '') {
        callback(new Error('请输入标题！'))
      }
    }
    var validateCategorys = (rule, value, callback) => {
      if (value === '') {
        callback(new Error('请选择分类！'))
      }
    }
    var validateTags = (rule, value, callback) => {
      if (value === '') {
        callback(new Error('请输入标签！'))
      }
    }
    var validateContent = (rule, value, callback) => {
      if (value === '') {
        callback(new Error('请输入内容！'))
      }
    }
  },
  computed: {
  },
  mounted() {
    const that = this
    if (that.id > 0) {
      that.getData()
    }
    // 获取文章分类
    that.getCategory()
  },
  methods: {
    // 将图片上传到服务器，返回地址替换到md中
    imgAdd(pos, $file) {
      const that = this
      const ajaxData = {}
      ajaxData.token = getToken()
      ajaxData.file = $file
      ajaxData.type = 'article_markdown'
      return new Promise((resolve, reject) => {
        uploadBase64(ajaxData).then(response => {
          that.$refs.md.$img2Url(pos, response.data.path)
          console.log(response.data.path)
          resolve()
        }).catch(error => {
          reject(error)
        })
      })
    },
    imgDel(pos) {

    },
    // 获取文章分类
    getCategory() {
      const that = this
      const ajaxData = {}
      ajaxData.token = getToken()
      return new Promise((resolve, reject) => {
        getCategoryList(ajaxData).then(response => {
          that.categorys_arr = response.data.data
          resolve()
        }).catch(error => {
          reject(error)
        })
      })
    },
    // 获取文章信息
    getData() {
      const that = this
      const ajaxData = {}
      ajaxData.token = getToken()
      return new Promise((resolve, reject) => {
        getOne(that.id, ajaxData).then(response => {
          that.ruleForm = response.data
          resolve()
        }).catch(error => {
          reject(error)
        })
      })
    },
    // 提交
    submitForm() {
      const that = this
      let ajaxData = {}
      ajaxData = that.ruleForm
      ajaxData.token = getToken()
      return new Promise((resolve, reject) => {
        if (that.id > 0) {
          // 更新
          update(that.id, ajaxData).then(response => {
            // commit('SET_TOKEN', data.token)
            // setToken(getToken())
            resolve()
            that.$router.push({ path: '/article/lists' })
          }).catch(error => {
            reject(error)
          })
        } else {
          // 新增
          add(ajaxData).then(response => {
            // commit('SET_TOKEN', data.token)
            // setToken(getToken())
            resolve()
            that.$router.push({ path: '/article/lists' })
          }).catch(error => {
            reject(error)
          })
        }
      })
    }
  }
}
</script>
