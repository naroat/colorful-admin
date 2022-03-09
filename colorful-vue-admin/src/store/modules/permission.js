import { asyncRoutes, constantRoutes } from '@/router'
// 获取菜单接口
import { getInfo } from '@/api/admin-user'
import Layout from '@/layout'

/**
 * 静态路由懒加载
 * @param view
 * @returns
 */
export const loadView = (view) => {
  return (resolve) => require([`@/views${view}`], resolve)
}

/**
 * 将后端获取的数据拼装
 * @param routes
 * @param data
 */
export function generaMenu(routes, data) {
  data.forEach(item => {
    const menu = {
      path: item.path === '#' ? item.menu_id + '_key' : item.path,
      component: item.component === '#' ? Layout : loadView(item.component),
      // hidden: true,
      children: [],
      name: 'menu_' + item.id,
      // meta: { title: item.name, id: item.id, roles: ['admin'] }
      meta: { title: item.name, id: item.id, icon: item.icon }
    }
    if (item.children) {
      generaMenu(menu.children, item.children)
    }
    routes.push(menu)
  })
}

/**
 * Use meta.role to determine if the current user has permission
 * @param roles
 * @param route
 */
// function hasPermission(roles, route) {
//   if (route.meta && route.meta.roles) {
//     return roles.some(role => route.meta.roles.includes(role))
//   } else {
//     return true
//   }
// }

const state = {
  routes: [],
  addRoutes: []
}

const mutations = {
  SET_ROUTES: (state, routes) => {
    state.addRoutes = routes
    state.routes = constantRoutes.concat(routes)
  }
}

const actions = {
  generateRoutes({ commit }, roles) {
    return new Promise(resolve => {
      const loadMenuData = []
      // 先查询后台并返回左侧菜单数据并把数据添加到路由
      getInfo(state.token).then(response => {
        // console.log(asyncRoutes)

        const data = response.data.menu
        Object.assign(loadMenuData, data)
        // for(var key in asyncRoutes) {
        //   if (key > 0) {
        //     delete asyncRoutes[key]
        //   }
        // }
        // 将后端获取的数据拼装
        generaMenu(asyncRoutes, loadMenuData)
        commit('SET_ROUTES', asyncRoutes)
        resolve(asyncRoutes)
      }).catch(error => {
        console.log(error)
      })
    })
  }
}

export default {
  namespaced: true,
  state,
  mutations,
  actions
}
