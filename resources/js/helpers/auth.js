import store from '@/store';
const user = store.state.auth.user
export const getRoles = () => {
  return user.roles||[];
}
export const getPermissions = () => {
  return user.permissions;
}


