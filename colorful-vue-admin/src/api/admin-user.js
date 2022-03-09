import request from '@/utils/request'

export function login(data) {
  return request({
    url: '/admin/login',
    method: 'post',
    data
  })
}

export function getInfo(token) {
  return request({
    url: '/admin/current/users',
    method: 'get',
    params: { token }
  })
}

export function logout() {
  return request({
    url: '/admin/logout',
    method: 'post'
  })
}

export function getAdminUsers(data) {
  return request({
    url: '/admin/admin/users',
    method: 'get',
    params: data
  })
}

export function getAdminUserOne(id, data) {
  return request({
    url: '/admin/admin/users/' + id,
    method: 'get',
    params: data
  })
}

export function addAdminUser(data) {
  return request({
    url: '/admin/admin/users',
    method: 'post',
    data
  })
}

export function updateAdminUser(id, data) {
  return request({
    url: '/admin/admin/users/' + id,
    method: 'put',
    data
  })
}

export function deleteAdminUser(id, data) {
  return request({
    url: '/admin/admin/users/' + id,
    method: 'delete',
    params: data
  })
}

export function updatePassword(id, data) {
  return request({
    url: '/admin/update/passwords/' + id,
    method: 'put',
    data
  })
}
