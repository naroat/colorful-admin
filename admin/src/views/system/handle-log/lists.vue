<template>
  <div>
    <p class="menu_name">操作日志</p>
    <div style="margin-left: 15px;  margin-bottom: 20px;">
      <div style="margin: 10px 0 0 0; display: inline-block;">
        <span style="padding-right:5px;">账号: </span><el-input v-model="searchList.account" placeholder="请输入" class="t-mr10" style="width: 200px;" />
      </div>
      <div style="margin: 10px 0 0 0; display: inline-block;">
        <el-button type="primary" @click="search()">搜索</el-button>
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
        prop="account"
        label="管理员账号"
        width="120"
      />
      <el-table-column
        prop="classes"
        label="类和方法"
      />
      <el-table-column
        prop="desc"
        label="描述"
      />
      <el-table-column
        prop="request_data"
        label="请求参数"
      />
      <el-table-column
        prop="response_data"
        label="响应"
      />
      <el-table-column
        prop="ip"
        label="IP"
      />
      <el-table-column
        prop="created_at"
        label="操作时间"
      />
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
import { getHandleLogs } from '@/api/admin-handle-log'
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
        getHandleLogs(ajaxData).then(response => {
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
      return new Promise((resolve, reject) => {
        getHandleLogs(ajaxData).then(response => {
          that.tableData = response.data.data
          that.total = response.data.total
          that.pageSize = response.data.per_page
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
