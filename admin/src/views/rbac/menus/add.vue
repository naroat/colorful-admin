<template>
  <div>
    <p v-if="id > 0" class="menu_name">编辑菜单</p>
    <p v-else class="menu_name">添加菜单</p>
    <el-form ref="ruleForm" :model="ruleForm" status-icon :rules="rules" label-width="100px" class="demo-ruleForm">
      <el-form-item label="标题" prop="name" style="width:600px;">
        <el-input v-model="ruleForm.name" type="text" />
      </el-form-item>
      <el-form-item label="路径" prop="desc" style="width:600px;">
        <el-input v-model="ruleForm.path" type="text" rows="4" />
      </el-form-item>
      <el-form-item label="组件" prop="desc" style="width:600px;">
        <el-input v-model="ruleForm.component" type="text" rows="4" />
      </el-form-item>
      <el-form-item label="icon" prop="desc" style="width:600px;">
        <el-input v-model="ruleForm.icon" type="text" rows="4" />
      </el-form-item>
      <el-form-item label="上级菜单" prop="categorys">
        <el-select
          v-model="ruleForm.p_id"
          placeholder="请选择"
        >
          <el-option
            v-for="item in parentMenus"
            :key="item.id"
            :label="item.name"
            :value="item.id"
          />
        </el-select>
      </el-form-item>
      <el-form-item label="排序" prop="sort" style="width:600px;">
        <el-input v-model="ruleForm.sort" type="text" />
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
import { getMenus, addMenu, getMenuOne, updateMenu } from '@/api/menu'
import { getToken } from '../../../utils/auth'
export default {
  components: { },

  data() {
    return {
      id: this.$route.query.id,
      tags_value: [],
      tags_arr: [],
      cat_id: '',
      menu_arr: [],
      tableData: [],
      ruleForm: {},
      parentMenus: [],
      rules: {
        name: [
          { required: true, trigger: 'blur', message: '请填写菜单名称！' }
        ]
      }
    }
  },
  computed: {
  },
  mounted() {
    console.log(this.id)
    const that = this
    if (that.id > 0) {
      that.getData()
    }
    that.getParentMenu()
  },
  methods: {
    getParentMenu() {
      const that = this
      const ajaxData = {}
      ajaxData.is_all = 1
      ajaxData.p_id = 0
      return new Promise((resolve, reject) => {
        getMenus(ajaxData).then(response => {
          that.parentMenus = response.data
          that.parentMenus.unshift({ id: 0, name: '一级菜单' })
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
        getMenuOne(that.id).then(response => {
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
          updateMenu(that.id, ajaxData).then(response => {
            resolve()
            that.$router.push({ path: '/rbac/menus/lists' })
          }).catch(error => {
            reject(error)
          })
        } else {
          // 新增
          addMenu(ajaxData).then(response => {
            resolve()
            that.$router.push({ path: '/rbac/menus/lists' })
          }).catch(error => {
            reject(error)
          })
        }
      })
    }
  }
}
</script>
