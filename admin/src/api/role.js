import request from '@/utils/request'

export function getRoles(data) {
  return request({
    url: '/admin/roles',
    method: 'get',
    params: data
  })
}

export function getRoleOne(id) {
  return request({
    url: `/admin/roles/${id}`,
    method: 'get'
  })
}

export function addRole(data) {
  return request({
    url: '/admin/roles',
    method: 'post',
    data
  })
}

export function updateRole(id, data) {
  return request({
    url: `/admin/roles/${id}`,
    method: 'put',
    data
  })
}

export function deleteRole(id) {
  return request({
    url: `/admin/roles/${id}`,
    method: 'delete'
  })
}
