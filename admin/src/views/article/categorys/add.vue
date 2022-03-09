<template>
  <div>
    <p v-if="id > 0" class="menu_name">更新</p>
    <p v-else class="menu_name">添加</p>
    <el-form ref="ruleForm" :model="ruleForm" status-icon :rules="rules" label-width="100px" class="demo-ruleForm">
      <el-form-item label="名称" prop="name" style="width:600px;">
        <el-input v-model="ruleForm.name" type="text" />
      </el-form-item>
      <el-form-item label="排序" prop="sort" style="width:400px;">
        <el-input v-model="ruleForm.sort" type="number" min="0" />
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
import { addCategory, getCategoryOne, updateCategory } from '@/api/article'
import { getToken } from '../../../utils/auth'

export default {
  components: { },

  data() {
    return {
      id: this.$route.query.id,
      tags_value: [],
      tags_arr: [],
      tableData: [],
      ruleForm: {},
      rules: {
        name: [
          { required: true, trigger: 'blur', message: '请输入分类名称！' }
        ]
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
  },
  methods: {
    // 获取信息
    getData() {
      const that = this
      const ajaxData = {}
      ajaxData.token = getToken()
      return new Promise((resolve, reject) => {
        getCategoryOne(that.id, ajaxData).then(response => {
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
      // that.ruleForm.sort = parseInt(that.ruleForm.sort);
      ajaxData = that.ruleForm
      ajaxData.token = getToken()
      return new Promise((resolve, reject) => {
        if (that.id > 0) {
          // 更新
          updateCategory(that.id, ajaxData).then(response => {
            // commit('SET_TOKEN', data.token)
            // setToken(getToken())
            resolve()
            that.$router.push({ path: '/article/categorys' })
          }).catch(error => {
            reject(error)
          })
        } else {
          // 新增
          addCategory(ajaxData).then(response => {
            // commit('SET_TOKEN', data.token)
            // setToken(getToken())
            resolve()
            that.$router.push({ path: '/article/categorys' })
          }).catch(error => {
            reject(error)
          })
        }
      })
    }
  }
}
</script>
