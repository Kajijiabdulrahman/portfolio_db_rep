# Abdulrahman Abubakar Kajiji — Portfolio

A responsive React portfolio built with Vite, preserving the original sunset-gradient design and using Supabase for project data and contact submissions.

## Stack

- React + React Router
- Vite
- Supabase JavaScript client
- Existing CSS design system and Bootstrap Icons

## Local development

1. Create a Supabase project and run [`supabase_schema.sql`](./supabase_schema.sql) in the Supabase SQL editor.
2. Copy [`.env.example`](./.env.example) to `.env.local`.
3. Set the browser-safe project URL and anon key:

   ```env
   VITE_SUPABASE_URL=https://your-project.supabase.co
   VITE_SUPABASE_ANON_KEY=your-anon-key
   ```

4. Install dependencies and start Vite:

   ```bash
   npm install
   npm run dev
   ```

The app works with seeded fallback project cards when Supabase is not configured. Once configured, the home page reads projects from the `projects` table and the contact form inserts into `messages`.

## Routes

- `/` — home and featured projects
- `/about` — profile and skills
- `/contact` — validated Supabase-backed contact form
- `/projects/taskflow`, `/projects/weatherscope`, `/projects/codecollab` — project details
- `/admin` — message overview UI

The public browser client never contains a database password or service-role key. The schema grants the anon role read access to projects and insert-only access to messages. Admin message management should be protected with Supabase Auth or a server-side Edge Function before production use; do not add public update/delete policies.

## Build

```bash
npm run build
npm run preview
```
