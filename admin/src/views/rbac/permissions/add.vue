<template>
  <div>
    <p v-if="id > 0" class="menu_name">更新</p>
    <p v-else class="menu_name">添加</p>
    <el-form ref="ruleForm" :model="ruleForm" status-icon :rules="rules" label-width="100px" class="demo-ruleForm">
      <el-form-item label="类型" prop="type" style="width:600px;">
        <el-radio v-model="ruleForm.type" label="0">菜单</el-radio>
        <el-radio v-model="ruleForm.type" label="1">按钮</el-radio>
        <el-radio v-model="ruleForm.type" label="2">其他</el-radio>
      </el-form-item>
      <el-form-item label="名称" prop="name" style="width:600px;">
        <el-input v-model="ruleForm.name" type="text" />
      </el-form-item>
      <el-form-item label="code" prop="code" style="width:600px;">
        <el-input v-model="ruleForm.code" type="text" />
      </el-form-item>
      <el-form-item label="菜单" prop="categorys">
        <el-cascader
          v-model="ruleForm.menu_ids"
          :props="props"
          :options="menus"
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
import { addPermission, getPermissionOne, updatePermission } from '@/api/permission'
import { getMenus } from '@/api/menu'
import { getToken } from '../../../utils/auth'

export default {
  components: { },

  data() {
    return {
      id: this.$route.query.id,
      props: { multiple: true, value: 'id', label: 'name', emitPath: false },
      menus: [],
      ruleForm: {
        type: '0'
      },
      rules: {
        type: [
          { required: true, trigger: 'blur', message: '请选择类型！' }
        ],
        name: [
          { required: true, trigger: 'blur', message: '请填写权限名称！' }
        ],
        code: [
          { required: true, trigger: 'blur', message: '请填写规则代码！' }
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
    that.getMenus()
  },
  methods: {
    getMenus() {
      const that = this
      const ajaxData = {}
      ajaxData.is_tree = 1
      ajaxData.is_all = 1
      return new Promise((resolve, reject) => {
        getMenus(ajaxData).then(response => {
          that.menus = response.data
          resolve()
        }).catch(error => {
          reject(error)
        })
      })
    },
    // 获取信息
    getData() {
      const that = this
      const ajaxData = {}
      return new Promise((resolve, reject) => {
        getPermissionOne(that.id, ajaxData).then(response => {
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
      return new Promise((resolve, reject) => {
        if (that.id > 0) {
          // 更新
          updatePermission(that.id, ajaxData).then(response => {
            resolve()
            that.$router.push({ path: '/rbac/permissions/lists' })
          }).catch(error => {
            reject(error)
          })
        } else {
          // 新增
          addPermission(ajaxData).then(response => {
            resolve()
            that.$router.push({ path: '/rbac/permissions/lists' })
          }).catch(error => {
            reject(error)
          })
        }
      })
    }
  }
}
</script>
