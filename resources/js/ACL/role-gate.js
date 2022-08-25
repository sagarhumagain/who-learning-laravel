export default class RoleGate{
    constructor(roles){
        this.roles = roles;
        console.log(roles);
    }

    isSuperAdmin(){
        return this.roles && this.roles?.includes("super-admin");
    }
    isCourseAdmin(){
        return this.roles && this.roles?.includes("course-admin");
    }
    isNormalUser(){
        return this.roles && this.roles?.includes("normal-user");
    }


}
