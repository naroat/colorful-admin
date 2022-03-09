<template>
  <div>
    <p class="menu_name">菜单列表</p>
    <div style="margin-left: 15px;  margin-bottom: 20px;">
      <div style="margin: 10px 0 0 0; display: inline-block;">
        <span style="padding-right:5px;">名称: </span><el-input v-model="searchList.name" placeholder="请输入" class="t-mr10" style="width: 200px;" />
      </div>
      <div style="margin: 10px 0 0 0; display: inline-block;">
        <el-button type="primary" @click="search()">搜索</el-button>
        <el-button type="primary" @click="goto('/rbac/menus/add')">新增</el-button>
      </div>
    </div>
    <el-table
      :data="tableData"
      border
      row-key="id"
      :tree-props="{children: 'children', hasChildren: 'hasChildren'}"
      style="width: 95%;margin-left:15px;"
    >
      <!-- <el-table-column
        fixed
        prop="id"
        label="ID"
        width="80"
      /> -->
      <el-table-column
        prop="name"
        label="菜单名称"
        width="150"
      />
      <el-table-column
        prop="path"
        label="路径"
        width="120"
      />
      <el-table-column
        prop="component"
        label="组件"
        width="120"
      />
      <el-table-column
        prop="icon"
        label="icon"
        width="180"
      />
      <el-table-column
        prop="p_id"
        label="上级"
        width="120"
      />
      <el-table-column
        prop="sort"
        label="排序"
        width="120"
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
          <el-button type="text" size="small" @click="goto('/rbac/menus/add?id=' + scope.row.id)">编辑</el-button>
          <el-button type="text" size="small" @click="del(scope.row)">删除</el-button>
        </template>
      </el-table-column>
    </el-table>
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
import { getMenus, deleteMenu } from '@/api/menu'
import { getToken } from '@/utils/auth'
import { formatDate } from '@/utils/common'
export default {
  name: 'MenuLists',
  data() {
    return {
      searchList: {},
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
    // 获取列表
    getList() {
      const that = this
      const ajaxData = {}
      ajaxData.is_tree = 1
      ajaxData.is_all = 1
      ajaxData.page = that.currentPage
      return new Promise((resolve, reject) => {
        getMenus(ajaxData).then(response => {
          that.tableData = response.data
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
        getMenus(ajaxData).then(response => {
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
        deleteMenu(res.id, ajaxData).then(response => {
          that.getList()
          resolve()
        }).catch(error => {
          reject(error)
        })
      })
    }
  }
}
</script>
