<template>
  <div>
    <p v-if="id > 0" class="menu_name">更新</p>
    <p v-else class="menu_name">添加</p>
    <el-form ref="ruleForm" :model="ruleForm" status-icon :rules="rules" label-width="100px" class="demo-ruleForm">
      <el-form-item label="名称" prop="name" style="width:400px;">
        <el-input v-model="ruleForm.name" type="text" />
      </el-form-item>
      <el-form-item label="权限" prop="permission_ids" style="width:600px;">
        <el-select
          v-model="ruleForm.permission_ids"
          multiple
          filterable
          placeholder="请选择"
        >
          <el-option
            v-for="item in permissions"
            :key="item.id"
            :label="item.name"
            :value="item.id"
          />
        </el-select>
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
import { addRole, getRoleOne, updateRole } from '@/api/role'
import { getPermissions } from '@/api/permission'
import { getToken } from '../../../utils/auth'

export default {
  components: { },

  data() {
    return {
      id: this.$route.query.id,
      ruleForm: {},
      permissions: [],
      rules: {
        name: [
          { required: true, trigger: 'blur', message: '请填写角色名称！' }
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
    that.getPermissions()
  },
  methods: {
    // 获取权限
    getPermissions() {
      const that = this
      const ajaxData = {}
      ajaxData.is_all = 1
      return new Promise((resolve, reject) => {
        getPermissions(ajaxData).then(response => {
          that.permissions = response.data
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
        getRoleOne(that.id, ajaxData).then(response => {
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
          updateRole(that.id, ajaxData).then(response => {
            resolve()
            that.$router.push({ path: '/rbac/roles/lists' })
          }).catch(error => {
            reject(error)
          })
        } else {
          // 新增
          addRole(ajaxData).then(response => {
            resolve()
            that.$router.push({ path: '/rbac/roles/lists' })
          }).catch(error => {
            reject(error)
          })
        }
      })
    }
  }
}
</script>
