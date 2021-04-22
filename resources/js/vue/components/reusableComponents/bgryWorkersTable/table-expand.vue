<style scoped>
    .expand-row{
        margin-bottom: 16px;
    }
</style>
<template>
    <div>
         <Button type="error" @click="updateStatus()" v-if="row.status === 'not verified'">Verify</Button>

        <Row class="expand-row">
            <Col span="8">
                <span class="expand-key" style="font-size:1rem;font-weight:900; ">Photo Selfie: </span>
                <span class="expand-value"><img :src="row.photo_selfie" style="width:300px;height:200px;" /></span>
            </Col>
            <Col span="8">
                <span class="expand-key" style="font-size:1rem;font-weight:900; ">Photo of Valid ID : </span>
                <span class="expand-value"><img :src="row.photo_id" style="width:300px;height:200px;" /></span>
            </Col>
        </Row>
        <Row class="expand-row">
            <Col span="8">
                <span class="expand-key" style="font-size:1rem;font-weight:900; ">Sectors : </span>
                <span class="expand-value" style="font-weight:700; font-size:.8rem; margin-right:10px;background:lightgrey;padding:10px;border-radius:50px" v-for="(sector,index) in sectors" :key="index">{{sector.sectorType}}</span>
            </Col>
        </Row>
        <Row class="expand-row">
            <Col span="8">
                <span class="expand-key" style="font-size:1rem;font-weight:900; ">Birthdate : </span>
                <span class="expand-value">{{row.birthdate}}</span>
            </Col>
            <Col span="8">
                <span class="expand-key" style="font-size:1rem;font-weight:900; ">Email : </span>
                <span class="expand-value">{{row.email}}</span>
            </Col>
            <Col span="8">
                <span class="expand-key" style="font-size:1rem;font-weight:900; ">Phone number : </span>
                <span class="expand-value">{{row.pnumber}}</span>
            </Col>
        </Row>
        
    </div>
</template>
<script>
    export default {
        props: {
            row: Object
        },
        data() {
            return {
                sectors : []
            }
        },
        methods: {
           async getSectors(){
             
                const res = await this.callApi('post' , '/app/get_sectorsById' , this.row)
                if(res.status === 200){
                  this.sectors = res.data
                console.log(res.data)
                }else{
			        this.swr()
		         }
                // console.log(this.row)
            },
            async updateStatus(){
                 const res = await this.callApi('put', '/app/update_status' ,this.row )
                 if(res.status === 200) {
                      console.log(res.data);
                      this.row.status = res.data.status
                    this.success(this.row.lname + ' is now a verified citizen');
                        }else{
                        if(res.status=== 422){
                            this.info('some error occured') 
                        }
                        else{
                            this.swr();
                            }
                        
                    }
            }
        },
        created() {
            this.getSectors();
        },
    };
</script>