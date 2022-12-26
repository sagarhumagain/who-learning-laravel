export default class PermissionGate{
    constructor(permissions){
        this.permissions = permissions;

    }

    CanAssignCourse(){
        return this.permissions && this.permissions.includes("course_assignment");
    }
   
}
   