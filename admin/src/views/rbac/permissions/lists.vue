<template>
  <div>
    <p class="menu_name">权限列表</p>
    <div style="margin-left: 15px;  margin-bottom: 20px;">
      <div style="margin: 10px 0 0 0; display: inline-block;">
        <span style="padding-right:5px;">名称: </span><el-input v-model="searchList.name" placeholder="请输入" class="t-mr10" style="width: 200px;" />
      </div>
      <div style="margin: 10px 0 0 0; display: inline-block;">
        <el-button type="primary" @click="search()">搜索</el-button>
        <el-button type="primary" @click="goto('/rbac/permissions/add')">新增</el-button>
      </div>
    </div>
    <el-table
      :data="tableData"
      border
      style="width: 95%;margin-left:15px;"
    >
      <el-table-column
        fixed
        prop="id"
        label="ID"
        width="50"
      />
      <el-table-column
        prop="name"
        label="名称"
        width="150"
      />
      <el-table-column
        prop="code"
        label="规则代码"
        width="400"
      />
      <el-table-column
        prop="type_text"
        label="类型"
      />
      <el-table-column
        prop="created_at"
        label="创建时间"
        width="180"
        :formatter="tranDate"
      />
      <el-table-column
        prop="updated_at"
        label="更新时间"
        width="180"
        :formatter="tranDate"
      />
      <el-table-column
        fixed="right"
        label="操作"
        width="100"
      >
        <template slot-scope="scope">
          <el-button type="text" size="small" @click="goto('/rbac/permissions/add?id=' + scope.row.id)">编辑</el-button>
          <el-button type="text" size="small" @click="del(scope.row)">删除</el-button>
        </template>
      </el-table-column>
    </el-table>
    <el-pagination
      background
      layout="total, prev, pager, next, jumper"
      :page-size="pageSize"
      :current-page="currentPage"
      :total="total"
      style="display: flex; justify-content:flex-end;width: 95%;margin-left:15px;margin-top:10px;"
      @current-change="handleCurrentChange"
      @prev-click="handlePrevClick"
      @next-click="handleNextClick"
    />
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
import { getPermissions, deletePermission } from '@/api/permission'
import { getToken } from '@/utils/auth'
import { formatDate } from '@/utils/common'
export default {

  data() {
    return {
      searchList: {},
      pageSize: 0,
      currentPage: 1,
      total: 0,
      tableData: []
    }
  },
  mounted() {
    const that = this
    that.getList()
  },
  methods: {
    goto(path) {
      this.$router.push({ path: path, query: {}})
    },
    tranDate(row, column, cellValue, index) {
      return formatDate(row[column.property])
    },
    // 页码改变时触发
    handleCurrentChange(page) {
      const that = this
      that.currentPage = page
      that.getList()
    },
    // 上一页
    handlePrevClick(page) {
      const that = this
      that.currentPage = page
      that.getList()
    },
    // 下一页
    handleNextClick(page) {
      const that = this
      that.currentPage = page
      that.getList()
    },
    // 获取列表
    getList() {
      const that = this
      const ajaxData = {}
      ajaxData.page = that.currentPage
      return new Promise((resolve, reject) => {
        getPermissions(ajaxData).then(response => {
          that.tableData = response.data.data
          that.total = response.data.total
          that.pageSize = response.data.per_page
          resolve()
        }).catch(error => {
          reject(error)
        })
      })
    },
    // 搜索
    search() {
      const that = this
      let ajaxData = {}
      ajaxData = that.searchList
      ajaxData.token = getToken()
      return new Promise((resolve, reject) => {
        getRoles(ajaxData).then(response => {
          that.tableData = response.data.data
          that.total = response.data.total

          that.pageSize = response.data.per_page
          resolve()
        }).catch(error => {
          reject(error)
        })
      })
    },
    // 删除
    del(res) {
      const that = this
      const ajaxData = {}
      ajaxData.token = getToken()
      return new Promise((resolve, reject) => {
        deletePermission(res.id, ajaxData).then(response => {
          that.getList()
          resolve()
        }).catch(error => {
          reject(error)
        })
      })
    },
    handleClick(row) {
      console.log(row)
    }
  }
}
</script>
