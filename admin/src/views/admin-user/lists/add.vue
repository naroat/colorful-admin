<template>
  <div>
    <p v-if="id > 0" class="menu_name">更新</p>
    <p v-else class="menu_name">添加</p>
    <el-form ref="ruleForm" :model="ruleForm" status-icon :rules="rules" label-width="100px" class="demo-ruleForm">
      <el-form-item label="账号" prop="account" style="width:600px;">
        <el-input v-model="ruleForm.account" type="text" />
      </el-form-item>
      <el-form-item v-if="!id" label="密码" prop="password" style="width:600px;">
        <el-input v-model="ruleForm.password" type="password" />
      </el-form-item>
      <el-form-item label="名称" prop="name" style="width:600px;">
        <el-input v-model="ruleForm.name" type="text" />
      </el-form-item>
      <el-form-item label="头像" prop="headimg" style="width:400px;">
        <el-upload
          class="avatar-uploader"
          action="/api/admin/uploads"
          :data="uploadData"
          :headers="uploadHeader"
          :show-file-list="false"
          :on-success="handleAvatarSuccess"
        >
          <img v-if="ruleForm.headimg" :src="ruleForm.headimg" class="avatar">
          <i v-else class="el-icon-plus avatar-uploader-icon" />
        </el-upload>
      </el-form-item>
      <el-form-item label="角色" prop="role_id" style="width:400px;">
        <el-select
          v-model="ruleForm.role_id"
          placeholder="请选择"
        >
          <el-option
            v-for="item in roles"
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
    font-size: 28px;
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
<script>
import Vue from 'vue'
import { addAdminUser, getAdminUserOne, updateAdminUser } from '@/api/admin-user'
import { getRoles } from '@/api/role'
import { upload } from '@/api/upload'
import { getToken } from '../../../utils/auth'

export default {
  components: { },

  data() {
    return {
      id: this.$route.query.id,
      roles: [],
      ruleForm: {
        headimg: ''
      },
      uploadData: { type: 'admin_user_headimg' },
      uploadHeader: { Authorization: 'Bearer ' + getToken() },
      rules: {
        name: [
          { required: true, trigger: 'blur', message: '请填写名称！' }
        ],
        account: [
          { required: true, trigger: 'blur', message: '请填写账号！' }
        ],
        password: [
          { required: true, trigger: 'blur', message: '请填写密码！' }
        ],
        role_id: [
          { required: true, trigger: 'blur', message: '请选择角色！' }
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
    that.getRoles()
  },
  methods: {
    // 获取角色
    getRoles() {
      const that = this
      const ajaxData = {}
      ajaxData.is_all = 1
      return new Promise((resolve, reject) => {
        getRoles(ajaxData).then(response => {
          that.roles = response.data
          resolve()
        }).catch(error => {
          reject(error)
        })
      })
    },
    handleAvatarSuccess(response, file, fileList) {
      this.ruleForm.headimg = response.data.path
    },
    // 获取信息
    getData() {
      const that = this
      const ajaxData = {}
      return new Promise((resolve, reject) => {
        getAdminUserOne(that.id, ajaxData).then(response => {
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
          updateAdminUser(that.id, ajaxData).then(response => {
            resolve()
            that.$router.push({ path: '/admin/user/lists' })
          }).catch(error => {
            reject(error)
          })
        } else {
          // 新增
          addAdminUser(ajaxData).then(response => {
            resolve()
            that.$router.push({ path: '/admin/user/lists' })
          }).catch(error => {
            reject(error)
          })
        }
      })
    }
  }
}
</script>
