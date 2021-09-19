import API from "@/services"
import { ref } from "vue"

export type userType = {
  id: number
  identify_card: string
  social_insurance: string
  fullname: string
  birthday: null
  gender: number
  username: string
  address: string
  phone: string
  village_id: number
  role_id: number
  created_at: null
  updated_at: null
}

function useUsers() {
  const data = ref<userType[]>([])
  const loadingListUser = ref(false)
  const totalPage = ref(0)
  const getListUsers = async (page: number) => {
    try {
      loadingListUser.value = true
      const response = await API.get("user?page=" + page)
      if (response.data.success) {
        data.value = response.data.data.users
        console.log(response.data.data.users)
        totalPage.value = response.data.data.meta.last_page
      }
    } catch (e) {
      console.log(e)
      loadingListUser.value = false
    } finally {
      loadingListUser.value = false
    }
  }

  const getListUsersSearch = async (fullname: string) => {
    try {
      loadingListUser.value = true
      const response = await API.get("user?fullname=" + fullname)
      if (response.data.success) {
        data.value = response.data.data.users
        console.log(response.data.data.users)
      }
    } catch (e) {
      console.log(e)
      loadingListUser.value = false
    } finally {
      loadingListUser.value = false
    }
  }

  // const getUserPages = async (page:number) => {
  //   try {
  //     loadingListUser.value = true;
  //     const response = await API.get("user?page=" + page);
  //     if (response.data.success) {
  //       data.value = response.data.data.users;
  //       console.log(response.data.data.users);
  //       totalPage.value = response.data.data.meta.last_page;
  //     }
  //   } catch (e) {
  //     console.log(e);
  //     loadingListUser.value = false;
  //   } finally {
  //     loadingListUser.value = false;
  //   }
  // }

  return {
    data,
    loadingListUser,
    getListUsers,
    getListUsersSearch,
    totalPage
    // getUserPages
  }
}

export default useUsers