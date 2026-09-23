import { createClient } from '@supabase/supabase-js'

const supabaseUrl = process.env.SUPABASE_URL || process.env.VITE_SUPABASE_URL
const serviceRoleKey = process.env.SUPABASE_SERVICE_ROLE_KEY

if (!supabaseUrl || !serviceRoleKey) {
  console.error('Missing required environment variables: SUPABASE_URL or SUPABASE_SERVICE_ROLE_KEY')
  console.error('Example:')
  console.error('  SUPABASE_URL=https://your-project.supabase.co')
  console.error('  SUPABASE_SERVICE_ROLE_KEY=your-service-role-key')
  process.exit(1)
}

const supabase = createClient(supabaseUrl, serviceRoleKey, {
  auth: {
    persistSession: false,
    autoRefreshToken: false,
  },
})

const projects = [
  {
    slug: 'taskflow',
    title: 'TaskFlow',
    tagline: 'A lightweight productivity app',
    description: 'A task manager with drag-and-drop, offline saving, and reminders.',
    hero_image_url: 'https://images.unsplash.com/photo-1484480974693-6ca0a78fb36b?auto=format&fit=crop&w=1200&q=80',
    youtube_video_id: 'dQw4w9WgXcQ',
    tech_stack: 'HTML,CSS,JavaScript,LocalStorage',
  },
  {
    slug: 'weatherscope',
    title: 'WeatherScope',
    tagline: 'Real-time weather dashboard',
    description: 'A dashboard showing current weather + 7-day forecast for any city.',
    hero_image_url: 'https://images.unsplash.com/photo-1504608524841-42fe6f032b4b?auto=format&fit=crop&w=1200&q=80',
    youtube_video_id: 'dQw4w9WgXcQ',
    tech_stack: 'JavaScript,REST API,Chart.js,CSS Grid',
  },
  {
    slug: 'codecollab',
    title: 'CodeCollab',
    tagline: 'Collaborative code editor',
    description: 'Multi-user real-time code editor with shared rooms.',
    hero_image_url: 'https://images.unsplash.com/photo-1522071820081-009f0129c71c?auto=format&fit=crop&w=1200&q=80',
    youtube_video_id: 'dQw4w9WgXcQ',
    tech_stack: 'React,Node.js,Socket.io,Monaco',
  },
]

const { data, error } = await supabase
  .from('projects')
  .upsert(projects, { onConflict: 'slug' })
  .select('slug, title')

if (error) {
  console.error('Seeding failed:', error)
  process.exit(1)
}

console.log('Seeded projects:', data.map((project) => project.slug).join(', '))
