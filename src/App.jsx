import { useEffect, useState } from 'react'
import { Link, NavLink, Route, Routes, useLocation, useNavigate, useParams } from 'react-router-dom'
import { isSupabaseConfigured, supabase } from './lib/supabase'
import { fallbackProjects, projectMeta } from './data/projects'

function useReveal() {
  useEffect(() => {
    const elements = document.querySelectorAll('.reveal:not(.is-visible)')
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches || !('IntersectionObserver' in window)) {
      elements.forEach((element) => element.classList.add('is-visible'))
      return
    }
    const observer = new IntersectionObserver((entries) => entries.forEach((entry) => {
      if (entry.isIntersecting) {
        entry.target.classList.add('is-visible')
        observer.unobserve(entry.target)
      }
    }), { threshold: 0.12 })
    elements.forEach((element) => observer.observe(element))
    return () => observer.disconnect()
  })
}

function Layout({ children }) {
  const [theme, setTheme] = useState(() => localStorage.getItem('ak-theme') || 'dark')
  const [menuOpen, setMenuOpen] = useState(false)
  const location = useLocation()
  useEffect(() => {
    document.documentElement.dataset.theme = theme
    localStorage.setItem('ak-theme', theme)
  }, [theme])
  useEffect(() => setMenuOpen(false), [location.pathname])
  useReveal()
  return <>
    <nav className="navbar">
      <div className="navbar-inner">
        <Link to="/" className="brand" aria-label="Abdulrahman Kajiji — Home"><span className="brand-badge">AK</span><span className="brand-name">Abdulrahman<span className="brand-dot">.</span></span></Link>
        <button className={`nav-toggle${menuOpen ? ' is-open' : ''}`} onClick={() => setMenuOpen((value) => !value)} aria-label="Toggle navigation menu" aria-expanded={menuOpen}><i className="bi bi-list nav-toggle-icon nav-icon-open" /><i className="bi bi-x nav-toggle-icon nav-icon-close" /></button>
        <div className={`nav-cluster${menuOpen ? ' is-open' : ''}`} id="navMenu">
          <ul className="nav-links">
            {[['/', 'home', 'bi-house-door', 'Home'], ['/about', 'about', 'bi-person-badge', 'About'], ['/contact', 'contact', 'bi-envelope-paper', 'Contact']].map(([to, page, icon, label]) => <li key={page}><NavLink to={to} className={({ isActive }) => `nav-link${isActive ? ' active' : ''}`}><i className={`bi ${icon}`} /> {label}</NavLink></li>)}
          </ul>
          <button className="theme-toggle" onClick={() => setTheme((value) => value === 'dark' ? 'light' : 'dark')} aria-label="Switch color theme"><i className="bi bi-moon-stars theme-icon-moon" /><i className="bi bi-sun theme-icon-sun" /></button>
        </div>
      </div>
    </nav>
    {children}
    <Footer />
  </>
}

function Footer() {
  return <footer className="footer"><div className="container footer-inner"><p className="footer-copy">&copy; {new Date().getFullYear()} Abdulrahman Abubakar Kajiji. All rights reserved.</p><div className="footer-meta"><a href="mailto:kajijiabdulrahman39@gmail.com" className="footer-link"><i className="bi bi-envelope" /> kajijiabdulrahman39@gmail.com</a><span className="footer-sep"><i className="bi bi-geo-alt" /> Nassarawa LGA, Kano State, Nigeria</span></div><div className="footer-social"><a href="https://github.com/" target="_blank" rel="noreferrer" className="footer-icon" aria-label="GitHub profile"><i className="bi bi-github" /></a><a href="mailto:kajijiabdulrahman39@gmail.com" className="footer-icon" aria-label="Send an email"><i className="bi bi-envelope" /></a></div></div></footer>
}

function SectionHeading({ title, subtitle }) {
  return <div className="section-head reveal"><h2 className="section-title">{title}<span className="title-underline" /></h2>{subtitle && <p className="section-subtitle">{subtitle}</p>}</div>
}

function Home() {
  const [projects, setProjects] = useState(fallbackProjects)
  useEffect(() => {
    if (!supabase) return
    supabase.from('projects').select('slug,title,tagline,description,hero_image_url,tech_stack').order('id').then(({ data, error }) => {
      if (!error && data?.length) setProjects(data)
    })
  }, [])
  return <><section className="hero"><div className="hero-glow" /><div className="container hero-inner"><span className="eyebrow-pill reveal"><i className="bi bi-stars" /> Available for opportunities</span><h1 className="hero-title reveal">Hi, I'm <span className="gradient-text">Abdulrahman Abubakar Kajiji</span></h1><p className="hero-subtitle reveal">Aspiring Tech Enthusiast &amp; Developer — building clean, useful, and user-friendly digital products while learning something new every day.</p><div className="hero-actions reveal"><Link to="/contact" className="btn btn-primary"><i className="bi bi-send" /> Get In Touch</Link><a href="#projects" className="btn btn-ghost"><i className="bi bi-kanban" /> View Projects</a></div><div className="hero-stats reveal"><div className="stat"><span className="stat-number gradient-text">3+</span><span className="stat-label">Projects</span></div><div className="stat"><span className="stat-number gradient-text">8+</span><span className="stat-label">Skills</span></div><div className="stat"><span className="stat-number gradient-text">&infin;</span><span className="stat-label">Curiosity</span></div></div></div></section><section className="section" id="projects"><div className="container"><SectionHeading title="Featured Projects" subtitle="Things I have designed and built while learning modern web development." /><div className="cards-grid">{projects.map((project) => { const meta = projectMeta[project.slug] || projectMeta.taskflow; return <article className="project-card reveal" key={project.slug}><div className="project-card-media"><img src={project.hero_image_url || meta.photo} alt={`${project.title} — project cover`} loading="lazy" /><span className="project-card-badge"><i className={`bi ${meta.icon}`} /></span></div><div className="project-card-body"><h3 className="project-card-title">{project.title}</h3><p className="project-card-desc">{project.description || project.tagline}</p><div className="tag-row">{(project.tech_stack || '').split(',').map((tech) => <span className="tag" key={tech}>{tech.trim()}</span>)}</div><Link to={`/projects/${project.slug}`} className="btn btn-primary btn-sm project-card-btn">View Project <i className="bi bi-arrow-right" /></Link></div></article> })}</div></div></section></>
}

function About() {
  return <section className="section section-first"><div className="container"><SectionHeading title="About Me" subtitle="Who I am, what I do, and what keeps me excited about technology." /><div className="about-grid"><div className="about-card reveal"><div className="avatar-ring"><div className="avatar">AK</div></div><h3 className="about-name">Abdulrahman Abubakar Kajiji</h3><p className="about-role">Web Developer &amp; Tech Enthusiast</p><p className="about-location"><i className="bi bi-geo-alt-fill" /> Nassarawa Local Government, Kano State, Nigeria</p></div><div className="about-bio reveal"><p>Hello! I'm <strong>Abdulrahman Abubakar Kajiji</strong>, a passionate and curious tech learner from Nassarawa Local Government, Kano State, Nigeria. My journey into technology started with a simple question — <em>"how does a website actually work?"</em> — and it quickly turned into a genuine love for building things for the web.</p><p>I enjoy every stage of bringing an idea to life: sketching the layout, writing clean HTML and CSS, adding interactivity with JavaScript, and connecting everything to a real backend with Supabase. What excites me most is creating products that are genuinely <strong>useful</strong>.</p><p>Right now I'm focused on strengthening my front-end foundations while continuously learning modern tools and frameworks. Every project teaches me something new about performance, accessibility, and writing code other people can read.</p><p>I'm currently <strong>open to internships, junior roles, and freelance opportunities</strong> where I can contribute, grow, and keep learning every single day.</p></div></div><div className="section-head reveal skills-head"><h2 className="section-title">Skills &amp; Tools<span className="title-underline" /></h2><p className="section-subtitle">The technologies I work with today — and keep sharpening.</p></div><div className="skills-grid reveal">{[['bi-filetype-html','HTML5'],['bi-filetype-css','CSS3'],['bi-filetype-js','JavaScript'],['bi-lightning-charge','React'],['bi-git','Git & GitHub'],['bi-phone','Responsive Design'],['bi-palette','UI Design Basics'],['bi-lightbulb','Problem Solving']].map(([icon, label]) => <span className="skill-pill" key={label}><i className={`bi ${icon}`} /> {label}</span>)}</div></div></section>
}

function Contact() {
  const [status, setStatus] = useState(null)
  const [sending, setSending] = useState(false)
  async function handleSubmit(event) {
    event.preventDefault()
    const form = event.currentTarget
    const name = String(form.elements.name.value ?? '').trim()
    const email = String(form.elements.email.value ?? '').trim()
    const subject = String(form.elements.subject.value ?? '').trim()
    const message = String(form.elements.message.value ?? '').trim()
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/i

    if (name.length < 2 || !emailPattern.test(email) || message.length < 10) {
      setStatus({ type: 'error', text: 'Please provide a valid name, email, and a message of at least 10 characters.' })
      return
    }

    if (!supabase) {
      setStatus({ type: 'error', text: 'The contact form is not configured yet. Add the Supabase environment variables and try again.' })
      return
    }

    setSending(true)
    try {
      const { error } = await supabase.from('messages').insert({
        name,
        email,
        subject: subject || null,
        message,
      })

      if (error) {
        setStatus({ type: 'error', text: 'Sorry — something went wrong while sending your message. Please try again in a moment.' })
        return
      }

      setStatus({ type: 'success', text: `Thank you, ${name}! Your message has been sent — I will reply as soon as I can.` })
      form.reset()
    } finally {
      setSending(false)
    }
  }
  return <section className="section section-first"><div className="container"><SectionHeading title="Get In Touch" subtitle="Have a question, an idea, or an opportunity? My inbox is always open." /><div className="contact-grid"><div className="contact-info"><div className="info-card reveal"><span className="info-icon"><i className="bi bi-person-fill" /></span><div><h3 className="info-title">Name</h3><p className="info-text">Abdulrahman Abubakar Kajiji</p></div></div><div className="info-card reveal"><span className="info-icon"><i className="bi bi-envelope-fill" /></span><div><h3 className="info-title">Email</h3><p className="info-text"><a className="info-link" href="mailto:kajijiabdulrahman39@gmail.com">kajijiabdulrahman39@gmail.com</a></p></div></div><div className="info-card reveal"><span className="info-icon"><i className="bi bi-geo-alt-fill" /></span><div><h3 className="info-title">Location</h3><p className="info-text">Nassarawa Local Government, Kano State, Nigeria</p></div></div></div><div className="contact-form-card reveal">{status && <div className={`alert alert-${status.type}`} role="alert"><i className={`bi ${status.type === 'success' ? 'bi-check-circle-fill' : 'bi-exclamation-triangle-fill'}`} /><span>{status.text}</span></div>}<form className="contact-form" onSubmit={handleSubmit}><div className="form-field"><label htmlFor="name">Name <span className="req">*</span></label><input id="name" name="name" placeholder="Your full name" required /></div><div className="form-field"><label htmlFor="email">Email <span className="req">*</span></label><input id="email" name="email" type="email" placeholder="you@example.com" required /></div><div className="form-field"><label htmlFor="subject">Subject <span className="optional">(optional)</span></label><input id="subject" name="subject" placeholder="What is this about?" /></div><div className="form-field"><label htmlFor="message">Message <span className="req">*</span></label><textarea id="message" name="message" rows="6" required placeholder="Tell me a little about your project or question (min. 10 characters)..." /></div><button className="btn btn-primary btn-block" disabled={sending}><i className="bi bi-send-fill" /> {sending ? 'Sending...' : 'Send Message'}</button></form></div></div></div></section>
}

function ProjectPage() {
  const { slug } = useParams()
  const meta = projectMeta[slug]
  if (!meta) return <NotFound />
  const title = slug === 'weatherscope' ? 'WeatherScope' : slug === 'codecollab' ? 'CodeCollab' : 'TaskFlow'
  return <><section className="project-hero" style={{ '--hero-img': `url('${meta.photo}')` }}><div className="project-hero-overlay" /><div className="container project-hero-inner reveal is-visible"><nav className="breadcrumb"><Link to="/">Home</Link><i className="bi bi-chevron-right" /><Link to="/#projects">Projects</Link><i className="bi bi-chevron-right" /><span>{title}</span></nav><h1 className="project-hero-title gradient-text">{title}</h1><p className="project-hero-tagline"><i className={`bi ${meta.icon}`} /> {meta.tagline}</p></div></section><section className="section"><div className="container"><div className="overview-grid"><div className="overview-text reveal"><h2 className="section-title">Project Overview<span className="title-underline" /></h2>{meta.overview.map((paragraph) => <p key={paragraph}>{paragraph}</p>)}</div><aside className="info-panel reveal"><h3 className="info-panel-title"><i className={`bi ${meta.icon}`} /> Project Info</h3><dl className="info-panel-list"><div className="info-panel-row"><dt><i className="bi bi-person-badge" /> Role</dt><dd>Front-End Developer</dd></div><div className="info-panel-row"><dt><i className="bi bi-calendar3" /> Timeline</dt><dd>{meta.timeline}</dd></div><div className="info-panel-row"><dt><i className="bi bi-code-slash" /> Tech Stack</dt><dd><ul className="tech-list">{meta.tech.map((tech) => <li key={tech}><i className="bi bi-check2" /> {tech}</li>)}</ul></dd></div></dl></aside></div></div></section><section className="section"><div className="container"><SectionHeading title="Key Features" subtitle="Thoughtful details built from scratch for a clean, useful experience." /><div className="features-grid">{meta.features.map(([icon, feature, description]) => <article className="feature-card reveal" key={feature}><span className="feature-icon"><i className={`bi ${icon}`} /></span><h3>{feature}</h3><p>{description}</p></article>)}</div></div></section></>
}

function Admin() {
  const [messages, setMessages] = useState([])
  useEffect(() => { if (supabase) supabase.from('messages').select('*').order('created_at', { ascending: false }).then(({ data }) => setMessages(data || [])) }, [])
  async function updateMessage(id, changes) { if (!supabase) return; await supabase.from('messages').update(changes).eq('id', id); setMessages((items) => items.map((item) => item.id === id ? { ...item, ...changes } : item)) }
  async function deleteMessage(id) { if (!supabase || !window.confirm('Delete this message? This cannot be undone.')) return; await supabase.from('messages').delete().eq('id', id); setMessages((items) => items.filter((item) => item.id !== id)) }
  return <main className="admin-body"><header className="dash-header"><div className="container dash-header-inner"><div><h1 className="dash-title"><i className="bi bi-speedometer2" /> Admin Dashboard</h1><p className="dash-welcome">Supabase message management</p></div><Link to="/" className="btn btn-light btn-sm"><i className="bi bi-globe2" /> View Site</Link></div></header><div className="dash-main container"><div className="dash-stats"><div className="stat-card reveal is-visible"><span className="stat-card-icon"><i className="bi bi-envelope-fill" /></span><div><span className="stat-card-number gradient-text">{messages.length}</span><span className="stat-card-label">Total Messages</span></div></div><div className="stat-card reveal is-visible"><span className="stat-card-icon"><i className="bi bi-envelope-exclamation-fill" /></span><div><span className="stat-card-number gradient-text">{messages.filter((message) => !message.is_read).length}</span><span className="stat-card-label">Unread Messages</span></div></div><div className="stat-card reveal is-visible"><span className="stat-card-icon"><i className="bi bi-kanban-fill" /></span><div><span className="stat-card-number gradient-text">{fallbackProjects.length}</span><span className="stat-card-label">Total Projects</span></div></div></div><section className="dash-panel reveal is-visible"><h2 className="dash-panel-title"><i className="bi bi-inbox" /> Contact Messages</h2>{!messages.length ? <div className="empty-state"><i className="bi bi-inbox" /><p>No messages yet. Configure Supabase and submit the portfolio form to see messages here.</p></div> : <div className="table-wrap"><table className="messages-table"><thead><tr><th>#</th><th>Name</th><th>Email</th><th>Subject</th><th>Message</th><th>Status</th><th>Actions</th></tr></thead><tbody>{messages.map((message) => <tr className={message.is_read ? 'row-read' : 'row-new'} key={message.id}><td>{message.id}</td><td className="cell-name">{message.name}</td><td><a className="table-mail" href={`mailto:${message.email}`}>{message.email}</a></td><td>{message.subject || '—'}</td><td className="cell-message">{message.message}</td><td><span className={`badge ${message.is_read ? 'badge-read' : 'badge-new'}`}>{message.is_read ? 'Read' : 'New'}</span></td><td><button className="btn btn-ghost btn-sm" onClick={() => updateMessage(message.id, { is_read: !message.is_read })}>{message.is_read ? 'Unread' : 'Mark read'}</button><button className="btn btn-danger btn-sm" onClick={() => deleteMessage(message.id)}>Delete</button></td></tr>)}</tbody></table></div>}</section></div></main>
}

function NotFound() { return <section className="section section-first"><div className="container empty-state"><i className="bi bi-compass" /><h2>Page not found</h2><Link to="/" className="btn btn-primary">Back home</Link></div></section> }

export default function App() {
  return <Routes>
    <Route path="/admin" element={<Admin />} />
    <Route path="/" element={<Layout><Home /></Layout>} />
    <Route path="/about" element={<Layout><About /></Layout>} />
    <Route path="/contact" element={<Layout><Contact /></Layout>} />
    <Route path="/projects/:slug" element={<Layout><ProjectPage /></Layout>} />
    <Route path="*" element={<Layout><NotFound /></Layout>} />
  </Routes>
}
