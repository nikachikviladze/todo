<template>

    <div class="container">
        <div class="row mt-3">
            <div class="col-md-12">
                <button class="mb-3 btn btn-outline-secondary" type="button" data-toggle="modal" data-target="#exampleModal">Add</button>
                <h3>To Do List</h3>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Title</th>
                            <th scope="col">Username</th>
                            <th scope="col">Deadline</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(result, index) in this.results" :key="index">
                            <th scope="row">{{result.id}}</th>
                            <td>{{result.title}}</td>
                            <td> <span v-if="result.user">{{result.user.name}}</span> </td>
                            <td>{{result.deadline}}</td>
                            <td>
                              <span v-if="result.status==0">To do</span>
                              <span v-if="result.status==1">In progress</span>
                              <span v-if="result.status==2">Complete</span>
                            </td>
                            <td>
                                <button  @click="showToDo(result.id)" class="btn btn-sm btn-outline-primary" type="button" data-toggle="modal" data-target="#exampleModal1">Edit</button>
                                <button @click="deleteToDo(result.id)" type="button" class="btn btn-sm btn-outline-danger">Delete</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <form @submit.prevent="addTodo">
          <div class="modal-body">
              <div class="form-group">
                <label>Title</label>
                <input class="form-control" placeholder="Enter Title" required v-model="todo.title">
              </div>
              <div class="form-group">
                <label>Users</label>
                <select class="form-control" v-model="todo.user_id">
                  <option v-for="(user, index) in this.users" :key="index" v-bind:value="user.id" >{{user.name}}</option>
                </select>
              </div>
              <div class="form-group">
                <label>deadline</label>
                <input type="date" class="form-control" required v-model="todo.deadline">
              </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Save changes</button>
          </div>
        </form>
    </div>
  </div>
</div>
<!-- Modal -->
<div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">EDIT todo</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <form @submit.prevent="editTodo(item.id)">
          <div class="modal-body">
              <div class="form-group">
                <label>Title</label>
                <input class="form-control" placeholder="Enter Title" required v-model="item.title">
              </div>
              <div class="form-group">
                <label>Users</label>
                <select class="form-control" v-model="item.user_id">
                  <option v-for="(user, index) in this.users" :key="index" v-bind:value="user.id" :selected="item.user_id == user.id">{{user.name}}</option>
                </select>
              </div>

              <div class="form-group">
                <label>Status</label>
                <select class="form-control" v-model="item.status">
                  <option :value="0" :selected="item.status == 0">To do</option>
                  <option :value="1" :selected="item.status == 1">In progress</option>
                  <option :value="2" :selected="item.status == 2">Complete</option>
                </select>
              </div>
              <div class="form-group">
                <label>deadline</label>
                <input type="date" class="form-control" required v-model="item.deadline">
              </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Save changes</button>
          </div>
        </form>
    </div>
  </div>
</div>

    </div>
</template>

<script>


    export default {
        data(){
            return {
                results:{},
                users:{},
                item:{},
                todo:{
                  title:'',
                  user_id:'',
                  deadline:'',
                  status:'',
                }
            }
        },
        created() {

          this.fetchData()
            

        },
        methods:{
            fetchData()
            {
                axios.get('/api/todo').then(resp=>{
                  this.results= resp.data.todos
                  this.users= resp.data.users
                    
                })
                
            },
            addTodo(){


              axios.post('/api/todo', {'title':this.todo.title, 
                                      'user_id':this.todo.user_id,
                                      'deadline':this.todo.deadline})
                   .then(resp=>{
                     this.todo.title=''
                     this.todo.user_id=''
                     this.todo.deadline=''

                    this.fetchData()

                    alert('success')
                })

            },
            showToDo(id){
                axios.get(`/api/todo/${id}`).then(resp=>{
                  this.item= resp.data                    
                })
            },
            editTodo(id){

              axios.post(`/api/todo/${id}`, {'title':this.item.title, 
                                      'user_id':this.item.user_id,
                                      'status':this.item.status,
                                      'deadline':this.item.deadline,
                                      '_method': 'PUT'})
                   .then(resp=>{

                    this.fetchData()
                    alert('success')
                })

            },
            deleteToDo(id){

                if(confirm('Are You Sure?')){

                    fetch(`/api/todo/${id}`, {
                        method: 'delete',
                    })
                    .then(resp=>{
                        this.fetchData()

                    })

                }
            },
        }
    }
</script>