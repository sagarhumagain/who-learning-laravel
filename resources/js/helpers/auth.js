import store from '@/store';
const user = JSON.parse(JSON.stringify(store.getters['auth/user']));
export const getRoles = () => {
  return user.roles||[];
}

export const getPermissions = () => {
  return user.permissions;
}

