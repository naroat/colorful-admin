import request from '@/utils/request'

export function getConfigs(id, data) {
  return request({
    url: '/admin/configs',
    method: 'get',
    params: data
  })
}

export function updateConfigBase(data) {
  return request({
    url: '/admin/config/base',
    method: 'post',
    data
  })
}
