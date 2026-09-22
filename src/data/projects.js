export const projectMeta = {
  taskflow: {
    icon: 'bi-kanban',
    photo: 'https://images.unsplash.com/photo-1484480974693-6ca0a78fb36b?auto=format&fit=crop&w=1200&q=80',
    tagline: 'A lightweight productivity app that makes organising your day feel effortless.',
    timeline: '3 weeks',
    tech: ['HTML5', 'CSS3', 'JavaScript', 'LocalStorage'],
    features: [
      ['bi-plus-square', 'Task Creation', 'Add tasks in seconds with titles, notes, and priority levels — no signup required.'],
      ['bi-arrows-move', 'Drag & Drop Board', 'Move tasks between To Do, In Progress, and Done with smooth pointer-based dragging.'],
      ['bi-cloud-slash', 'Offline Saving', 'Every change is written to localStorage instantly — your board survives refreshes and outages.'],
      ['bi-bar-chart', 'Progress Tracking', 'A live progress ring and counters show how much of your day you have conquered.'],
      ['bi-moon', 'Dark Mode', 'Automatic theme switching that respects your system preference, day or night.'],
      ['bi-bell', 'Reminders', 'Set due dates and TaskFlow nudges you with gentle in-app reminders before deadlines.'],
    ],
    overview: [
      'TaskFlow started as a personal challenge: could I build a to-do app that people would actually enjoy using, without a single line of backend code? The answer became a fully client-side productivity tool that runs instantly in the browser and remembers everything you do.',
      'The core of TaskFlow is a fast task pipeline — add a task, drag it between "To Do", "In Progress", and "Done" columns, and watch your progress bar fill up in real time. Every change is saved to localStorage the moment it happens, so even if you close the tab or go offline, your board is exactly where you left it when you come back.',
      'I paid special attention to the small details: satisfying drag-and-drop animations, keyboard-friendly task creation, automatic due-date reminders, and a dark mode that respects your system preference.',
    ],
  },
  weatherscope: {
    icon: 'bi-cloud-sun',
    photo: 'https://images.unsplash.com/photo-1504608524841-42fe6f032b4b?auto=format&fit=crop&w=1200&q=80',
    tagline: 'A real-time weather dashboard for any city on Earth.',
    timeline: '4 weeks',
    tech: ['JavaScript (ES6+)', 'REST API', 'Chart.js', 'CSS Grid'],
    features: [
      ['bi-search', 'City Search', 'Debounced autocomplete finds any city worldwide as you type — no page reloads.'],
      ['bi-thermometer-sun', 'Current Conditions', 'Temperature, humidity, wind, and UV index presented in a clean, glanceable card.'],
      ['bi-calendar-week', '7-Day Forecast', 'A scrollable week-ahead forecast with icons, highs and lows for every day.'],
      ['bi-graph-up', 'Animated Charts', 'Chart.js visualisations of temperature and humidity trends across the week.'],
      ['bi-geo-alt', 'Auto-Location', "One tap uses the browser's geolocation API to load your local weather instantly."],
      ['bi-wifi-off', 'Offline Cache', 'The last successful lookup is cached, so the dashboard opens instantly every time.'],
    ],
    overview: [
      'WeatherScope is my first serious dive into working with third-party REST APIs. Type any city into the search bar and the dashboard instantly paints a complete picture of the weather there — current conditions, a seven-day forecast, and animated charts of temperature and humidity trends.',
      'Under the hood, the app fetches live data from a public weather API, normalises it into a clean internal format, and renders it with pure CSS Grid and Chart.js.',
      'Error handling was a big part of this project. Cities that do not exist, network timeouts, and rate limits are all caught gracefully and explained to the user with friendly inline messages.',
    ],
  },
  codecollab: {
    icon: 'bi-code-square',
    photo: 'https://images.unsplash.com/photo-1522071820081-009f0129c71c?auto=format&fit=crop&w=1200&q=80',
    tagline: 'A collaborative code editor where teams write together, in real time.',
    timeline: '6 weeks',
    tech: ['React', 'Node.js', 'Socket.io', 'Monaco Editor'],
    features: [
      ['bi-people', 'Shared Rooms', 'Create a room and share a short code — teammates join in seconds, no accounts needed.'],
      ['bi-cursor', 'Live Cursors', "See every participant's cursor and selection moving in real time, colour-coded per user."],
      ['bi-magic', 'Smart Editing', 'Monaco powers syntax highlighting and completions for dozens of languages.'],
      ['bi-chat-dots', 'Built-in Chat', 'A sidebar chat keeps discussion next to the code, with unread indicators.'],
      ['bi-arrow-repeat', 'Conflict Sync', 'Operational-transform sync keeps every copy of the document consistent, even offline edits.'],
      ['bi-download', 'Session Export', 'Download the final file, or a transcript of the session, when the session ends.'],
    ],
    overview: [
      'CodeCollab is the most ambitious project I have taken on so far: a multi-user, real-time code editor where several people can type in the same file at the same time and see each other’s cursors move live.',
      'The architecture is a React front-end talking to a Node.js server over Socket.io WebSockets. Every keystroke is broadcast to everyone in a shared room, where a lightweight operational transform keeps all copies of the document in sync.',
      'This project pushed me deep into asynchronous programming, WebSocket lifecycle management, and conflict resolution.',
    ],
  },
}

export const fallbackProjects = Object.entries(projectMeta).map(([slug, meta]) => ({
  slug,
  title: slug === 'weatherscope' ? 'WeatherScope' : slug === 'codecollab' ? 'CodeCollab' : 'TaskFlow',
  description: meta.tagline,
  tagline: meta.tagline,
  tech_stack: meta.tech.join(','),
  hero_image_url: meta.photo,
}))
