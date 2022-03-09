import request from '@/utils/request'

export function getPermissions(data) {
  return request({
    url: '/admin/permissions',
    method: 'get',
    params: data
  })
}

export function getPermissionOne(id) {
  return request({
    url: `/admin/permissions/${id}`,
    method: 'get'
  })
}

export function addPermission(data) {
  return request({
    url: '/admin/permissions',
    method: 'post',
    data
  })
}

export function updatePermission(id, data) {
  return request({
    url: `/admin/permissions/${id}`,
    method: 'put',
    data
  })
}

export function deletePermission(id) {
  return request({
    url: `/admin/permissions/${id}`,
    method: 'delete'
  })
}
