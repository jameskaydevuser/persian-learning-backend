# Railway Deployment Guide

## Prerequisites
1. GitHub account
2. Railway account (sign up at https://railway.app)

## Deployment Steps

### 1. Push to GitHub
```bash
cd persian-learning-backend
git init
git add .
git commit -m "Initial commit"
git remote add origin YOUR_GITHUB_REPO_URL
git push -u origin main
```

### 2. Deploy to Railway

1. Go to https://railway.app
2. Click "Start a New Project"
3. Choose "Deploy from GitHub repo"
4. Select your repository
5. Railway will auto-detect Laravel and deploy

### 3. Add Database

1. In your Railway project, click "New"
2. Select "Database" → "MySQL"
3. Railway will automatically set the DATABASE_URL environment variable

### 4. Set Environment Variables

In Railway project settings, add these variables:
- `APP_KEY` → Run `php artisan key:generate --show` locally and copy the key
- `APP_URL` → Your Railway app URL (e.g., `https://your-app.railway.app`)
- `APP_ENV` → `production`
- `APP_DEBUG` → `false`

### 5. Run Migrations

In Railway's terminal or locally:
```bash
railway run php artisan migrate --force
railway run php artisan db:seed
```

### 6. Storage Link

Railway will create the storage link automatically via the start command.

## Your Railway URL

After deployment, you'll get a URL like:
`https://persian-learning-backend-production.up.railway.app`

Update this URL in:
- `Speaking/services/api.ts` → `API_BASE_URL`
- `persian-learning-backend/app/Http/Controllers/ParentAudioController.php` → audio file URLs

## Testing

Test your API at:
- `https://your-app.railway.app/api/test`
- `https://your-app.railway.app/api/categories`

