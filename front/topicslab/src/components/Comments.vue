<template>
  <div>
    <Fieldset v-for="comment in comments" :key="comment.id">
      <template #legend>
        <span><!--10変更点-->
          <router-link :to="`/user/${comment.user.id}`">{{comment.user.name}}</router-link>
        </span>
      </template>
      <div class="comment-text">
        {{comment.body}}
        <span>
          <span>いいね！</span>
          <button @click="()=>countUp(comment)">{{ comment.count }}</button>
        </span>
      </div>
    </Fieldset>
  </div>
</template>

<script>
// import axios from '@/supports/axios'
export default {
  name: 'Comments',
  props: {
    comments: Array
  },
  data () {
    return {
      topic: {},
      user: {},
      id: null
    }
  },
  mounted () {
    this.id = this.$route.params.id
    if (!this.id) {
      alert('不正なIDです。')
    }
  },
  methods: {
    countUp (comment) {
      if (!comment.count) comment.count = 0
      comment.count++
      console.log(comment)
      // axios.get('/sanctum/csrf-cookie')
      //   .then(() => {
      //     axios.post(`/api/comments/${this.id}`)
      //       .then(res => {
      //         console.log(res)
      //       })
      //       .catch(err => {
      //         console.log(err)
      //       })
      //   })
      //   .catch((err) => {
      //     alert(err)
      //   })
    }
  }
}
</script>

<style lang="scss" scoped>
.p-fieldset {
  margin-top: 20px;
}

.comment-text {
  white-space:pre-wrap;
}
</style>
