# Tool Compatibility & Workflow Optimization

## Efficient Tool Usage Strategy
- **Minimize Requests**: Get maximum benefit from each tool usage
- **Batch Operations**: Group operations whenever possible
- **Strategic Reading**: Read necessary files at once (max 5 files)
- **Context Preservation**: Use read information in subsequent operations

## Available Tools & Capabilities

### File Operations
- **read_file**: Can read up to 5 files in a single request, PDF/DOCX supported, line-numbered output
- **write_to_file**: Create new file or completely rewrite, automatic directory creation
- **apply_diff**: Edit multiple files with targeted changes in single request (SEARCH/REPLACE), start_line required
- **insert_content**: Add content to specific line number (0=end of file, 1+=before specific line)

### Code Analysis Tools
- **search_files**: Regex search across files, context-rich results, file_pattern filter
- **list_files**: List directory contents (recursive=true/false), workspace relative paths
- **list_code_definition_names**: List code definitions (class, function), single file or directory

### System Operations
- **execute_command**: Execute CLI commands (artisan, composer, npm etc.), optional cwd parameter
- **Docker Commands**: ALL Laravel commands MUST use `docker-compose exec app-monexa php artisan [command]`
- **fetch_instructions**: Get instructions for MCP server, mode creation (create_mcp_server, create_mode)

### MCP Integration
- **use_mcp_tool**: Use MCP server tools (context7, fetch API etc.), JSON arguments
- **access_mcp_resource**: Access MCP server resources, URI-based resources

### Communication & Management
- **ask_followup_question**: Ask user optional questions (2-4 suggestions), optional mode switching
- **update_todo_list**: Task tracking and progress monitoring ([x], [-], [ ] statuses)
- **attempt_completion**: Present final results (user confirmation required first)
- **switch_mode**: Switch to different modes (code, architect, ask, debug, orchestrator etc.)
- **new_task**: Create new task instance (mode + message parameters)

## Multi-File Operations Strategy
- **IMPORTANT: You MUST use multiple files in a single operation whenever possible to maximize efficiency and minimize back-and-forth.**
- **Efficient Reading Strategy**: Get maximum benefit from each tool usage
- **Batch Operations**: Group operations whenever possible
- **Strategic Reading**: Read necessary files at once (max 5 files)
- **Context Preservation**: Use read information in subsequent operations

When you need to read more than 5 files, prioritize the most critical files first, then use subsequent read_file requests for additional files

## Tool Usage Efficiency Rules
- **Wait for Confirmation**: Always wait for user confirmation after each tool usage
- **One Tool Per Message**: Use only one tool per message
- **Complete Information**: Gather all necessary information for tool parameters
- **Error Handling**: Try alternative methods when tool fails
- **Context Awareness**: Always evaluate environment_details

## Laravel Project Workflow
- **Analysis Phase**: composer.json → config/app.php → routes → models
- **Planning Phase**: Read related files in batch, identify patterns
- **Implementation Phase**: Make related changes in single apply_diff
- **Docker Commands**: Always use `docker-compose exec app-monexa php artisan` for Laravel operations
- **Verification Phase**: Check file status only when necessary

## File Reading Strategy
- **Related Files**: Read related files together (model + controller + migration)
- **Context Gathering**: First understand general structure, then go into details
- **Prioritize Critical**: Give priority to core business logic files
- **Avoid Re-reading**: Don't re-read previously read files

## Implementation Patterns
- **Single Request Rule**: Try to complete an operation in single tool call
- **Progressive Enhancement**: Progress from simple → complex structure
- **Dependency Aware**: Consider dependencies
- **Error Prevention**: Anticipate possible errors beforehand

## Financial System Specific
- **Transaction Safety**: Perform critical operations within DB::transaction()
- **Validation First**: Plan input validation before writing code
- **Security Checks**: Include Auth, KYC, CRON_KEY controls
- **Logging Strategy**: Define log points for audit trail

## Code Quality Gates
- **Pre-implementation**: Validate requirements before writing code
- **Single Responsibility**: Each change should focus on single responsibility
- **Test Consideration**: Consider testability of written code
- **Documentation**: Document complex business logic

## Tool Limitations & Constraints
- **read_file**: Maximum 5 files per request, PDF/DOCX support for binary files
- **apply_diff**: SEARCH section requires exact match, whitespace sensitive
- **write_to_file**: Complete content required, line_count parameter mandatory
- **execute_command**: Each command runs in new terminal instance, Docker commands mandatory for Laravel
- **MCP Tools**: Requires server connection, one tool at a time usage
- **File Paths**: Workspace relative paths (c:/Users/kadobey/Desktop/Monexa/monexafinans)

## Best Practices Summary
- **Analysis First**: Analyze project structure and environment_details first
- **Batch Operations**: Read and edit related files at once
- **Error Prevention**: Validate tool parameters before usage
- **User Feedback**: Wait for confirmation after each tool usage
- **Efficiency Focus**: Achieve maximum results with minimum tool usage