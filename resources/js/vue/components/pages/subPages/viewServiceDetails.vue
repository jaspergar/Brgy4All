<template lang="">
    <div>
        <div class="content">
            <div class="container-fluid">
                <h1 style="text-align:center;margin-bottom:1rem">
                    Service details
                </h1>
                <div class="info_container">
                    <img
                        :src="serviceDetails.serviceImage"
                        class="info_image"
                    />
                    <div class="info_details_container">
                        <div class="info_details">
                            <h4 class="info_details_title">Title :</h4>
                            <p class="info_details_description">
                                {{ serviceDetails.serviceTitle }}
                            </p>
                        </div>
                        <div class="info_details">
                            <h4 class="info_details_title">Service Type :</h4>
                            <p class="info_details_description">
                                {{ serviceDetails.serviceType }}
                            </p>
                        </div>
                        <div class="info_details">
                            <h4 class="info_details_title">Status :</h4>
                            <p class="info_details_description">
                                {{ serviceDetails.serviceStatus }}
                            </p>
                        </div>
                        <div class="info_details">
                            <h4 class="info_details_title">
                                Number of Citizen :
                            </h4>
                            <p class="info_details_description">
                                {{ serviceDetails.numberOfBeneficiaries }}
                            </p>
                        </div>
                         <!-- <div class="info_details">
                            <h4 class="info_details_title">
                                Total citizen claimed service:
                            </h4>
                            <p class="info_details_description">
                                {{ serviceDetails.numberOfBeneficiaries }}
                            </p>
                            
                             <h4 class="info_details_title">
                                Total citizen not claimed service:
                            </h4>
                            <p class="info_details_description">
                                {{ serviceDetails.numberOfBeneficiaries }}
                            </p>
                        </div> -->
                        
                    </div>
                </div>

                <div class="info_container">
                    <div class="info_description">
                        <h4 class="info_details_title">Description :</h4>
                        <p class="info_details_description">
                            {{ serviceDetails.serviceDescription }}
                        </p>
                    </div>
                </div>
                <h1 style="text-align:center;margin-bottom:1rem">
                    Citizen Attendance List
                </h1>
                <TableExpand />
            </div>
        </div>
    </div>
</template>
<script>
import TableExpand from "../../reusableComponents/serviceAttendanceTable/table";
export default {
    name: "ServiceDetail",
    data() {
        return {
            id: this.$route.params.id,
            serviceDetails: {}
        };
    },
    methods: {
        async getServiceFullDetails() {
            const res = await this.callApi(
                "post",
                "/app/getFullServiceDetails/" + this.id
            );
            if (res.status === 200) {
                this.serviceDetails = res.data;
            }
        },
        async getServiceAttendanceList() {
            const res = await this.callApi(
                "post",
                "/app/getServiceAttendanceList/" + this.id
            );
            if (res.status === 200) {
                let array = [];
                let list = [
                    // 'attendanceList' : [],
                    // 'status' : []
                ];
                array = res.data;
                array.forEach(element => {
                    list.push(element.list);
                    //  list.attendanceList.push(element.list)
                    //  list.status.push(element->status)
                });
                this.$store.commit("setServiceAttendanceList", list);
            }
        }
    },
    created() {
        this.getServiceFullDetails();
        this.getServiceAttendanceList();
    },
    components: {
        TableExpand
    }
};
</script>
<style scoped>
.info_container {
    display: flex;
    padding: 2rem 5rem;
    background: white;
    margin-bottom: 1rem;
}

.info_image {
    width: 40%;
    height: 300px;
    object-fit: fill;
    margin-right: 2rem;
}
.info_details_container {
    padding: 2rem;
    width: 60%;
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    gap: 2rem;
    background: #f5f5f5;
    border-radius: 10px;
}
.info_details {
    display: flex;
    gap: 1rem;
    justify-content: center;
    align-items: center;
}
.info_details_description {
    font-size: 1rem;
    color: #111;
    letter-spacing: 1px;
}

.info_description {
    display: flex;
    gap: 1rem;
    justify-content: center;
    align-items: center;
}
</style>
