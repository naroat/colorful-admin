import request from '@/utils/request'

export function getMenus(data) {
  return request({
    url: '/admin/menus',
    method: 'get',
    params: data
  })
}

export function getMenuOne(id) {
  return request({
    url: `/admin/menus/${id}`,
    method: 'get'
  })
}

export function addMenu(data) {
  return request({
    url: '/admin/menus',
    method: 'post',
    data
  })
}

export function updateMenu(id, data) {
  return request({
    url: `/admin/menus/${id}`,
    method: 'put',
    data
  })
}

export function deleteMenu(id) {
  return request({
    url: `/admin/menus/${id}`,
    method: 'delete'
  })
}
