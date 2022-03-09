<template>
  <div>
    <p class="menu_name">网站设置</p>
    <el-form ref="ruleForm" :model="ruleForm" status-icon :rules="rules" label-width="100px" class="demo-ruleForm">
      <el-form-item label="网站名称" prop="base_setting_name" style="width:600px;">
        <el-input v-model="ruleForm.base_setting_name" type="text" />
      </el-form-item>
      <el-form-item label="关键词" prop="base_setting_keyword" style="width:600px;">
        <el-input v-model="ruleForm.base_setting_keyword" type="textarea" rows="4" />
      </el-form-item>
      <el-form-item label="网站描述" prop="base_setting_description" style="width:600px;">
        <el-input v-model="ruleForm.base_setting_description" type="textarea" rows="4" />
      </el-form-item>
      <el-form-item label="关于" prop="about_us">
        <mavon-editor
          ref="md"
          v-model="ruleForm.about_us"
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
import { getConfigs, updateConfigBase } from '@/api/config'
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
      ruleForm: {},
      rules: {
        base_setting_name: [
          { required: true, trigger: 'blur', message: '请填写网站名称！' }
        ],
        base_setting_keyword: [
          { required: true, trigger: 'blur', message: '请填写网站关键词！' }
        ],
        base_setting_description: [
          { required: true, trigger: 'blur', message: '请填写网站描述！' }
        ]
      }
    }
  },
  computed: {
  },
  mounted() {
    const that = this
    that.getData()
  },
  methods: {
    // 将图片上传到服务器，返回地址替换到md中
    imgAdd(pos, $file) {
      const that = this
      const ajaxData = {}
      ajaxData.token = getToken()
      ajaxData.file = $file
      ajaxData.type = 'about_us'
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
    imgDel() {

    },
    // 获取信息
    getData() {
      const that = this
      const ajaxData = {}
      return new Promise((resolve, reject) => {
        getConfigs(that.id, ajaxData).then(response => {
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
      // ajaxData.token = getToken()
      return new Promise((resolve, reject) => {
        // 更新
        updateConfigBase(ajaxData).then(response => {
          // commit('SET_TOKEN', data.token)
          // setToken(getToken())
          resolve()
          that.$router.push({ path: '/configs' })
        }).catch(error => {
          reject(error)
        })
      })
    }
  }
}
</script>
