# Tool Compatibility & Workflow Optimization

## Efficient Tool Usage Strategy
- **Minimize Requests**: Her tool kullanımından maksimum fayda sağla
- **Batch Operations**: Mümkün olduğunda işlemleri grupla
- **Strategic Reading**: Gerekli dosyaları tek seferde oku (max 5 dosya)
- **Context Preservation**: Okunan bilgileri sonraki işlemlerde kullan

## Available Tools & Capabilities

### File Operations
- **read_file**: Tek request'te 5 dosyaya kadar okuyabilir, PDF/DOCX destekli, line-numbered output
- **write_to_file**: Yeni dosya oluştur veya tamamen yeniden yaz, otomatik directory creation
- **apply_diff**: Tek request'te birden çok dosyayı hedefli düzenle (SEARCH/REPLACE), start_line gerekli
- **insert_content**: Belirli satır numarasına content ekle (0=dosya sonu, 1+=belirli satır öncesi)

### Code Analysis Tools
- **search_files**: Regex ile dosyalar arası arama, context-rich sonuçlar, file_pattern filtresi
- **list_files**: Dizin içeriği listele (recursive=true/false), workspace relative paths
- **list_code_definition_names**: Kod tanımları (class, function) listele, tek dosya veya directory

### System Operations
- **execute_command**: CLI komutları çalıştır (artisan, composer, npm vs.), optional cwd parameter
- **fetch_instructions**: MCP server, mode creation için talimatlar al (create_mcp_server, create_mode)

### MCP Integration
- **use_mcp_tool**: MCP server tools kullan (context7, fetch API vs.), JSON arguments
- **access_mcp_resource**: MCP server kaynaklarına erişim, URI-based resources

### Communication & Management
- **ask_followup_question**: Kullanıcıya seçenekli soru sor (2-4 suggestion), optional mode switching
- **update_todo_list**: Task tracking ve ilerleme takibi ([x], [-], [ ] statuses)
- **attempt_completion**: Final sonuçları sun (user confirmation required first)
- **switch_mode**: Farklı mode'lara geçiş (code, architect, ask, debug, orchestrator vs.)
- **new_task**: Yeni task instance oluştur (mode + message parameters)

## Multi-File Operations Strategy
- **IMPORTANT: You MUST use multiple files in a single operation whenever possible to maximize efficiency and minimize back-and-forth.**
- **Efficient Reading Strategy**: Her tool kullanımından maksimum fayda sağla
- **Batch Operations**: Mümkün olduğunda işlemleri grupla
- **Strategic Reading**: Gerekli dosyaları tek seferde oku (max 5 dosya)
- **Context Preservation**: Okunan bilgileri sonraki işlemlerde kullan

When you need to read more than 5 files, prioritize the most critical files first, then use subsequent read_file requests for additional files

## Tool Usage Efficiency Rules
- **Wait for Confirmation**: Her tool kullanımından sonra mutlaka user confirmation bekle
- **One Tool Per Message**: Her mesajda sadece bir tool kullan
- **Complete Information**: Tool parametreleri için gereken tüm bilgiyi topla
- **Error Handling**: Tool başarısızlığı durumunda alternatif yöntemler dene
- **Context Awareness**: environment_details'i her zaman değerlendir

## Laravel Project Workflow
- **Analysis Phase**: composer.json → config/app.php → routes → models
- **Planning Phase**: İlgili dosyaları toplu oku, pattern'leri tespit et
- **Implementation Phase**: İlgili değişiklikleri tek apply_diff'te yap
- **Verification Phase**: Sadece gerektiğinde dosya durumunu kontrol et

## File Reading Strategy
- **Related Files**: İlişkili dosyaları birlikte oku (model + controller + migration)
- **Context Gathering**: Önce genel yapıyı anla, sonra detaya in
- **Prioritize Critical**: Core business logic dosyalarına öncelik ver
- **Avoid Re-reading**: Daha önce okunan dosyaları tekrar okuma

## Implementation Patterns
- **Single Request Rule**: Bir işlemi tek tool call'da tamamlamaya çalış
- **Progressive Enhancement**: Basit → kompleks yapıya doğru ilerle
- **Dependency Aware**: Bağımlılıkları göz önünde bulundur
- **Error Prevention**: Olası hataları önceden tahmin et

## Financial System Specific
- **Transaction Safety**: Kritik işlemleri DB::transaction() içinde yap
- **Validation First**: Input validation'ı kod yazmadan önce planla
- **Security Checks**: Auth, KYC, CRON_KEY kontrollerini dahil et
- **Logging Strategy**: Audit trail için log noktalarını belirle

## Code Quality Gates
- **Pre-implementation**: Kod yazmadan önce requirements'ı doğrula
- **Single Responsibility**: Her değişiklik tek sorumluluğa odaklanmalı
- **Test Consideration**: Yazılan kodun test edilebilirliğini düşün
- **Documentation**: Karmaşık business logic'i dokümante et

## Tool Limitations & Constraints
- **read_file**: Maksimum 5 dosya per request, binary files için PDF/DOCX desteği
- **apply_diff**: SEARCH section exact match gerektirir, whitespace sensitive
- **write_to_file**: Complete content required, line_count parametresi zorunlu
- **execute_command**: Her command yeni terminal instance'da çalışır
- **MCP Tools**: Server connection gerektirir, one tool at a time usage
- **File Paths**: Workspace relative paths (c:/Users/kadobey/Desktop/Monexa/monexafinans)

## Best Practices Summary
- **Analysis First**: Proje yapısını ve environment_details'i önce analiz et
- **Batch Operations**: İlgili dosyaları tek seferde oku ve düzenle
- **Error Prevention**: Tool parametrelerini kullanmadan önce doğrula
- **User Feedback**: Her tool kullanımından sonra confirmation bekle
- **Efficiency Focus**: Minimum tool usage ile maximum sonuç al