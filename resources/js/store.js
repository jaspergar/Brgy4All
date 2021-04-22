import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex) 

export default new Vuex.Store({
    state: {
        deleteModalObj: {
            showModal: false,
            deleteUrl: '',
            data: null,
            index : -1,
            isDeleted : false
        },
        generatedListObj:{
            serviceId : null,
            list : []
        },
        serviceAttendanceList:[],
        user:false
    },
    getters: {
         //delete state
        getDeleteModalObj(state){
           return state.deleteModalObj
        },
        getIsDeletedState(state){
            const data = {
                'isDeleted' : state.deleteModalObj.isDeleted,
                'index' : state.deleteModalObj.index
            }
            return data
        },
          //delete state end
        
        getGeneratedList(state){
            return state.generatedListObj
        },
         getServiceAttendanceList(state){
            return state.serviceAttendanceList
        },

        //user
        getUserState(state){
                return state.user   
        }

    },
    mutations: {
        setIsDeleted(state,data){
            state.deleteModalObj.showModal = false
           state.deleteModalObj.isDeleted = data
        },
        setDeleteModalObj(state, data){
            state.deleteModalObj = data
        },
        setGeneratedList(state,data){
            state.generatedListObj = data
        },
        setServiceAttendanceList(state,data){
            state.serviceAttendanceList = data
        },
        updateUser(state, data){
            state.user = data
        }
    },
    actions :{
        updateUserAction({commit},data){
            commit('updateUser',data)
       },
    }
})