<template>
  <div>
    <p class="menu_name">列表</p>
    <div style="margin-left: 15px;  margin-bottom: 20px;">
      <div style="margin: 10px 0 0 0; display: inline-block;">
        <span style="padding-right:5px;">标题: </span><el-input v-model="searchList.name" placeholder="请输入" class="t-mr10" style="width: 200px;" />
      </div>
      <div style="margin: 10px 0 0 0; display: inline-block;">
        <span style="padding-right:5px;">创建时间: </span>
        <el-date-picker
          v-model="searchList.time"
          type="datetimerange"
          :picker-options="pickerOptions"
          range-separator="至"
          start-placeholder="开始日期"
          end-placeholder="结束日期"
          align="right"
          class="t-mr10"
          value-format="timestamp"
        />
      </div>
      <div style="margin: 10px 0 0 0; display: inline-block;">
        <el-button type="primary" @click="search()">搜索</el-button>
        <el-button type="primary" @click="goto('/article/categorys/add')">新增</el-button>
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
        label="标题"
      />
      <el-table-column
        prop="sort"
        label="权重"
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
          <!-- <el-button type="text" size="small" @click="handleClick(scope.row)">查看</el-button> -->
          <el-button type="text" size="small" @click="goto('/article/categorys/add?id=' + scope.row.id)">编辑</el-button>
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
import { getCategoryList, destoryCategory } from '@/api/article'
import { getToken } from '@/utils/auth'
import { formatDate } from '@/utils/common'
export default {

  data() {
    return {
      searchList: {},
      pageSize: 0,
      currentPage: 1,
      total: 0,
      tableData: [],
      pickerOptions: {
        shortcuts: [{
          text: '最近一周',
          onClick(picker) {
            const end = new Date()
            const start = new Date()
            start.setTime(start.getTime() - 3600 * 1000 * 24 * 7)
            picker.$emit('pick', [start, end])
          }
        }, {
          text: '最近一个月',
          onClick(picker) {
            const end = new Date()
            const start = new Date()
            start.setTime(start.getTime() - 3600 * 1000 * 24 * 30)
            picker.$emit('pick', [start, end])
          }
        }, {
          text: '最近三个月',
          onClick(picker) {
            const end = new Date()
            const start = new Date()
            start.setTime(start.getTime() - 3600 * 1000 * 24 * 90)
            picker.$emit('pick', [start, end])
          }
        }]
      }
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
      ajaxData.token = getToken()
      ajaxData.page = that.currentPage
      return new Promise((resolve, reject) => {
        getCategoryList(ajaxData).then(response => {
          that.tableData = response.list.data
          that.total = response.list.total
          // that.pageSize = parseInt(response.list.per_page);
          that.pageSize = response.list.per_page
          // commit('SET_TOKEN', data.token)
          // setToken(getToken())
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
        getCategoryList(ajaxData).then(response => {
          that.tableData = response.list.data
          that.total = response.list.total
          // that.pageSize = parseInt(response.list.per_page);
          that.pageSize = response.list.per_page
          // commit('SET_TOKEN', data.token)
          // setToken(getToken())
          resolve()
        }).catch(error => {
          reject(error)
        })
      })
    },
    // 删除文章
    del(res) {
      const that = this
      const ajaxData = {}
      ajaxData.token = getToken()
      return new Promise((resolve, reject) => {
        destoryCategory(res.id, ajaxData).then(response => {
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
