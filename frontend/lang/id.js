export default async ({$axios}, locale) => {
  return await $axios.$get('/api/lang', { params: { locale: 'id' } });
}
