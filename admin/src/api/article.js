import request from '@/utils/request'

export function getList(data) {
  return request({
    url: '/admin/articles',
    method: 'get',
    params: data
  })
}

export function getOne(id, data) {
  return request({
    url: '/admin/articles/' + id,
    method: 'get',
    params: data
  })
}

export function add(data) {
  return request({
    url: '/admin/articles',
    method: 'post',
    data
  })
}

export function update(id, data) {
  return request({
    url: '/admin/articles/' + id,
    method: 'put',
    data
  })
}

export function destory(id, data) {
  return request({
    url: '/admin/articles/' + id,
    method: 'delete',
    params: data
  })
}

// 导航分类操作
export function getCategoryList(data) {
  return request({
    url: '/admin/article/categorys',
    method: 'get',
    params: data
  })
}

export function getCategoryOne(id, data) {
  return request({
    url: '/admin/article/categorys/' + id,
    method: 'get',
    params: data
  })
}

export function addCategory(data) {
  return request({
    url: '/admin/article/categorys',
    method: 'post',
    data
  })
}

export function updateCategory(id, data) {
  return request({
    url: '/admin/article/categorys/' + id,
    method: 'put',
    data
  })
}

export function destoryCategory(id, data) {
  return request({
    url: '/admin/article/categorys/' + id,
    method: 'delete',
    params: data
  })
}
