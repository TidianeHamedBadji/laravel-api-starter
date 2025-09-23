# Contributing to Laravel API Starter

Thank you for considering contributing to Laravel API Starter! We welcome contributions from the community.

## Table of Contents

- [Code of Conduct](#code-of-conduct)
- [How to Contribute](#how-to-contribute)
- [Development Setup](#development-setup)
- [Testing](#testing)
- [Coding Standards](#coding-standards)
- [Pull Request Process](#pull-request-process)
- [Reporting Issues](#reporting-issues)

## Code of Conduct

This project adheres to a code of conduct. By participating, you are expected to uphold this code. Please report unacceptable behavior to [tidiane.hamedbadji@gmail.com](mailto:tidiane.hamedbadji@gmail.com).

### Our Standards

- Use welcoming and inclusive language
- Be respectful of differing viewpoints and experiences
- Gracefully accept constructive criticism
- Focus on what is best for the community
- Show empathy towards other community members

## How to Contribute

### Types of Contributions

We welcome several types of contributions:

1. **Bug Reports** - Help us identify and fix issues
2. **Feature Requests** - Suggest new functionality
3. **Code Contributions** - Submit bug fixes or new features
4. **Documentation** - Improve our documentation
5. **Testing** - Help us improve test coverage
6. **Translation** - Help translate documentation to other languages

### Before You Start

1. Check existing [issues](https://github.com/TidianeHamedBadji/laravel-api-starter/issues) to see if your bug/feature is already being discussed
2. For major changes, please open an issue first to discuss the proposed changes
3. Fork the repository and create a new branch for your contribution

## Development Setup

### Prerequisites

- PHP 8.1 or higher
- Composer
- Git

### Setup Instructions

1. **Fork and Clone**
   ```bash
   # Fork the repository on GitHub, then clone your fork
   git clone https://github.com/YOUR_USERNAME/laravel-api-starter.git
   cd laravel-api-starter
   ```

2. **Install Dependencies**
   ```bash
   composer install
   ```

3. **Create a Branch**
   ```bash
   git checkout -b feature/your-feature-name
   # or
   git checkout -b fix/your-bug-fix
   ```

4. **Make Your Changes**
   - Write your code
   - Add tests for new functionality
   - Update documentation if needed

## Testing

### Running Tests

```bash
# Run all tests
composer test

# Run tests with coverage
composer test-coverage

# Run specific test files
vendor/bin/phpunit tests/Feature/ApiStarterCommandTest.php
```

### Writing Tests

- Add feature tests for new commands or major functionality
- Add unit tests for service classes and utilities
- Ensure tests are descriptive and cover edge cases
- Follow existing test patterns and naming conventions

### Test Requirements

- All new features must have tests
- Bug fixes should include regression tests
- Maintain or improve test coverage
- Tests should be fast and reliable

## Coding Standards

### PHP Standards

We follow PSR-12 coding standards with some additional rules:

```bash
# Check code style
composer format

# Analyze code
composer analyse
```

### Code Style Guidelines

- Use descriptive variable and method names
- Add PHPDoc comments for classes and methods
- Follow Laravel naming conventions
- Use type hints and return types
- Keep methods small and focused

### File Organization

```
src/
├── Commands/           # Artisan commands
├── Services/          # Business logic services
├── Providers/         # Service providers
└── Stubs/            # Template files

tests/
├── Feature/          # Integration tests
└── Unit/            # Unit tests

stubs/               # Stub templates
├── controllers/
├── models/
├── requests/
├── resources/
├── services/
└── seeders/
```

## Pull Request Process

### Before Submitting

1. **Ensure Your Code Works**
   - Run all tests and ensure they pass
   - Test your changes manually
   - Check code style compliance

2. **Update Documentation**
   - Update README if needed
   - Add/update inline code comments
   - Update CHANGELOG.md

3. **Commit Guidelines**
   ```bash
   # Use conventional commit format
   git commit -m "feat: add new API generation feature"
   git commit -m "fix: resolve issue with model namespace"
   git commit -m "docs: update installation instructions"
   ```

### Commit Message Format

Use the [Conventional Commits](https://www.conventionalcommits.org/) format:

- `feat:` - New features
- `fix:` - Bug fixes
- `docs:` - Documentation changes
- `style:` - Code style changes (formatting, etc.)
- `refactor:` - Code refactoring
- `test:` - Adding or updating tests
- `chore:` - Maintenance tasks

### Pull Request Checklist

- [ ] Tests pass
- [ ] Code follows style guidelines
- [ ] Documentation is updated
- [ ] CHANGELOG.md is updated
- [ ] Commit messages follow convention
- [ ] No merge conflicts
- [ ] Description explains what and why

### Pull Request Description

Please include:

1. **Summary** - Brief description of changes
2. **Motivation** - Why this change is needed
3. **Changes** - Detailed list of what was changed
4. **Testing** - How you tested the changes
5. **Screenshots** - If applicable for UI changes

## Reporting Issues

### Bug Reports

Please include:

1. **Laravel version** you're using
2. **PHP version**
3. **Package version**
4. **Steps to reproduce** the issue
5. **Expected behavior**
6. **Actual behavior**
7. **Error messages** or logs
8. **Additional context** that might help

### Feature Requests

Please include:

1. **Problem description** - What problem does this solve?
2. **Proposed solution** - How should it work?
3. **Alternatives considered** - Other approaches you've thought about
4. **Additional context** - Examples, use cases, etc.

### Issue Templates

We provide issue templates to help you provide the necessary information:

- Bug Report Template
- Feature Request Template
- Documentation Issue Template

## Development Guidelines

### Adding New Features

1. **Plan the Feature**
   - Open an issue to discuss the feature
   - Consider backward compatibility
   - Think about configuration options

2. **Implementation**
   - Follow existing patterns
   - Add appropriate configuration
   - Include error handling

3. **Documentation**
   - Update configuration docs
   - Add usage examples
   - Update README if needed

4. **Testing**
   - Add comprehensive tests
   - Test edge cases
   - Verify backward compatibility

### Modifying Stubs

When modifying stub templates:

1. Keep them generic and reusable
2. Use clear placeholder names
3. Follow Laravel conventions
4. Test with various model names
5. Update documentation examples

### Adding Configuration Options

1. Add to `config/api-starter.php`
2. Document the option
3. Provide sensible defaults
4. Consider backward compatibility
5. Add tests for the new option

## Getting Help

If you need help with contributing:

1. **Documentation** - Check our comprehensive docs
2. **Discussions** - Use GitHub Discussions for questions
3. **Issues** - Create an issue for bugs or feature requests
4. **Email** - Contact [tidiane.hamedbadji@gmail.com](mailto:tidiane.hamedbadji@gmail.com) for sensitive matters

## Recognition

Contributors will be recognized in:

- GitHub contributors list
- README credits section
- Release notes for significant contributions

Thank you for contributing to Laravel API Starter! 🚀