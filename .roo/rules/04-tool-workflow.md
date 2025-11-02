# Tool Compatibility & Workflow Optimization

## Efficient Tool Usage Strategy
- **Batch Operations**: Read max 5 files at once, group related operations
- **codebase_search**: MANDATORY FIRST for ANY new code exploration
- **Wait for Confirmation**: One tool per message, confirm before proceeding
- **Context Preservation**: Use information from previous operations

## Available Tools & Capabilities

### File Operations
- **read_file**: Max 5 files, PDF/DOCX support, line-numbered output
- **write_to_file**: Complete rewrite, auto-create directories, line_count required
- **apply_diff**: Targeted SEARCH/REPLACE with start_line, exact whitespace match
- **insert_content**: Add at line number (0=end, 1+=before line)

### Code Analysis Tools
- **search_files**: Regex search, context results, file_pattern filter
- **list_files**: Directory contents, recursive option
- **list_code_definition_names**: Code definitions overview
- **codebase_search**: Semantic search (MANDATORY first step)

### System Operations
- **execute_command**: CLI commands, Docker MANDATORY: `docker-compose exec app-monexa php artisan [command]`
- **fetch_instructions**: MCP server, mode creation instructions

### MCP Integration Tools
- **use_mcp_tool**: JSON arguments, sequential execution only
- **access_mcp_resource**: URI-based resources

#### MCP Servers
**Puppeteer** (`puppeteer`): Web automation, testing, screenshots
- Tools: navigate, screenshot, click, fill, select, hover, evaluate
- Resource: `console://logs` for browser console
- Security: Use `allowDangerous: true` for `--no-sandbox`

**MCP_DOCKER** (`MCP_DOCKER`): Content fetching, library docs, knowledge graph
- Tools: fetch, resolve-library-id, get-library-docs, knowledge graph management
- Parameters: url, max_length, raw, start_index, libraryName, context7CompatibleLibraryID

### Communication & Management
- **ask_followup_question**: 2-4 suggestions, optional mode switching
- **update_todo_list**: Track progress ([x], [-], [ ])
- **attempt_completion**: Present final results
- **switch_mode**: Change modes (code, architect, debug, etc.)

## Workflow Patterns

### Laravel Project Workflow
1. **Analysis**: codebase_search → composer.json → config → routes → models
2. **Planning**: Read related files in batch (model + controller + migration)
3. **Implementation**: Single apply_diff for related changes
4. **Verification**: Check status only when necessary

### MCP Usage Patterns
**Web Testing**: navigate → interact (click/fill) → screenshot → console logs
**Documentation**: resolve-library-id → get-library-docs → fetch → knowledge graph
**Laravel Testing**: Docker environment, multi-page workflows, error monitoring
**Fintech Testing**: Auth flows (2FA, KYC), financial operations, real-time features

## Key Rules & Constraints
- **Multi-File Strategy**: Read related files together, batch operations
- **MCP Sequential**: One tool per request, parameter validation required
- **Docker Commands**: Always use container-based Laravel commands
- **File Paths**: Workspace relative paths (/home/kadir/dev/monexafinans)
- **Error Prevention**: Validate parameters, prepare fallbacks

## Financial System Specific
- **Transaction Safety**: DB::transaction() for critical operations
- **Security**: Auth, KYC, CRON_KEY verification required
- **Validation**: Input validation, bcmath for calculations
- **Audit**: Log financial operations

## Tool Limitations
- read_file: 5 files max, whitespace sensitive for apply_diff
- MCP: Server connection required, sequential execution only
- Docker: Container commands mandatory for Laravel

## Best Practices
- Use codebase_search first for ANY new code exploration
- Batch read/edit operations for efficiency
- Wait for user confirmation after each tool
- Validate parameters before tool usage
- Consider security implications for MCP tools